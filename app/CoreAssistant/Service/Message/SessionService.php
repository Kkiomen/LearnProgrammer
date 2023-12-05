<?php

namespace App\CoreAssistant\Service\Message;

use Illuminate\Support\Str;

class SessionService
{
    public function __construct(
        private readonly ConversationService $conversationService
    ){}

    public function generateSession(): string
    {
        do{
            $uuid = (string) Str::uuid();
        }while($this->conversationService->isExistsConversationBySessionHash($uuid));

        return $uuid;
    }


}
