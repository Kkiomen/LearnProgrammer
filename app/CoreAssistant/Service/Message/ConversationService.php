<?php

namespace App\CoreAssistant\Service\Message;

use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class ConversationService
{
    public function createMessage(MessageProcessor $messageProcessor): Message
    {
        $conversation = $this->getOrCreateConversations($messageProcessor->getSessionHash());

        return Message::create([
            'conversation_id' => $conversation->id,
            'user_message' => $messageProcessor->getMessageFromUser()
        ]);
    }


    public function getOrCreateConversations(string $sessionHash): Conversation
    {
        $conversation = Conversation::where('session_hash')->first();

        if($conversation){
            return $conversation;
        }

        return Conversation::create([
            'session_hash' => $sessionHash
        ]);
    }

    public function getConversationMessages(?string $sessionHash): array
    {
        $conversation = Conversation::where('session_hash', $sessionHash)->first();

        if($conversation){
            return $conversation->messages->toArray();
        }

        return [];
    }

    public function isExistsConversationBySessionHash(string $sessionHash): bool
    {
        return Conversation::where('session_hash', $sessionHash)->exists();
    }
}
