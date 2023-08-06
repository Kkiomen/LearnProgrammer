<?php

namespace App\Helpers;

use App\Abstract\Command;
use App\Abstract\MessageData;
use App\Enum\TypeMessage;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageHelper
{

    public static function isSnippet(MessageData $messageData): bool
    {
        return !is_null($messageData->mode);
    }

    public static function getConversation(User $user, int $conversationId = null): Conversation
    {
        if ($conversationId) {
            $conversation = Conversation::find($conversationId);

            if ($conversation && $conversation->avatar == $user->active_avatar) {
                Conversation::where('user_id', $user->id)
                    ->where('active', 1)
                    ->update(['active' => 0]);

                $conversation->update(['active' => 1]);
                Auth::user()->update(['active_conversation' => $conversation->id]);

                return $conversation;
            }
        }

        $conversation = Conversation::where('user_id', $user->id)
            ->where('avatar', $user->active_avatar)
            ->where('active', 1)
            ->first();

        if ($conversation) {
            return $conversation;
        }

        $conversation = new Conversation();
        $conversation->user_id = $user->id;
        $conversation->active = true;
        $conversation->avatar = $user->active_avatar;
        $conversation->save();

        $user->update(['active_conversation' => $conversation->id]);
        return $conversation;
    }


    public static function getAllConversationMessages($convesationId = null)
    {
        $user = Auth::user();
        return Message::where('conversation_id', self::getConversation($user, $convesationId)->id)->orderBy('created_at', 'asc')->get();
    }

    public static function getConversationMessages()
    {
        $user = Auth::user() ?? User::where('id', 1)->first();
        return Message::where('conversation_id', self::getConversation($user)->id)->where('type', TypeMessage::TEXT->value)->orderBy('created_at', 'asc')->get();
    }

    public static function clearConversation(): void
    {
        $user = Auth::user() ?? User::where('id', 1)->first();
        $conversation = self::getConversation($user);
        $conversation->active = false;
        $conversation->save();
    }

}
