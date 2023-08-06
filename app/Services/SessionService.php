<?php

namespace App\Services;

use App\Class\Conversation\Repository\ConversationRepository;

class SessionService
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
    )
    {
    }

    public function generateSession(): string
    {
        return $this->conversationRepository->getNewSessionHashConversation();
    }
}
