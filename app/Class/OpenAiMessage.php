<?php

namespace App\Class;

use App\Enum\TypeMessage;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class OpenAiMessage
{

    public function addMessage($message, $snippet = null, $avatar = null){
        Message::create([
            'user_id' => Auth::user()->id,
            'conversation_id' => $this->getConversation()->id,
            'message' => $message,
            'snippet' => $snippet,
            'avatar' => $avatar ?? null
        ]);
    }

    public function addResult($result, TypeMessage $typeMessage, $prompt = null, $systemPrompt = null, $messageId = null): void
    {
        if(!empty($messageId)){
            $message = Message::where('user_id', Auth::user()->id)->where('id', $messageId)->first();
        }else{
            $message = Message::where('user_id', Auth::user()->id)
                ->whereNotNull('message')
                ->whereNull('result')
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if($message){
            $message->result = $result;
            if(is_null($message->type)){
                $message->type = $typeMessage->value;
            }

            if(!is_null($prompt)){
                $message->prompt = $prompt;
            }

            if(!is_null($systemPrompt)){
                $message->system = $systemPrompt;
            }

            $message->save();
        }
    }

    public static function updateSnippet(string $snippet, ?int $messageId = null){
        if(!empty($messageId)){
            $message = Message::where('user_id', Auth::user()->id)->where('id', $messageId)->first();
        }else{
            $message = Message::where('user_id', Auth::user()->id)
                ->whereNotNull('message')
                ->whereNull('result')
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if($message){
            $message->snippet = $snippet;
            $message->type = TypeMessage::SNIPPET->value;
            $message->save();
        }
    }


    public static function getMessage(){
        if(!empty($messageId)){
            $message = Message::where('user_id', Auth::user()->id)->where('id', $messageId)->first();
        }else{
            $message = Message::where('user_id', Auth::user()->id)
                ->whereNotNull('message')
                ->whereNull('result')
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if($message){
            return $message;
        }
    }

    /**
     * Get Conversation id
     */
    public function getConversation($conversationId = null): Conversation
    {
        if ($conversationId) {
            $conversation = Conversation::find($conversationId);

            if ($conversation && $conversation->avatar == Auth::user()->active_avatar) {
                Conversation::where('user_id', Auth::user()->id)
                    ->where('active', 1)
                    ->update(['active' => 0]);

                $conversation->update(['active' => 1]);
                Auth::user()->update(['active_conversation' => $conversation->id]);

                return $conversation;
            }
        }

        $conversation = Conversation::where('user_id', Auth::user()->id)
            ->where('avatar', Auth::user()->active_avatar)
            ->where('active', 1)
            ->first();

        if ($conversation) {
            return $conversation;
        }

        $user = Auth::user();

        $conversation = new Conversation();
        $conversation->user_id = $user->id;
        $conversation->active = true;
        $conversation->avatar = $user->active_avatar;
        $conversation->save();

        Auth::user()->update(['active_conversation' => $conversation->id]);
        return $conversation;
    }
}
