<?php

namespace App\Class\Conversation\Factory;

use App\Class\Conversation\ConversationDTO;
use App\Class\Conversation\Enum\ConversationStatus;
use App\Class\Conversation\Interface\ConversationInterface;

class ConversationFactory
{
    public function createConversationDTO(
        int $id = null,
        int $assistantId = null,
        int $consultantId = null,
        string $sessionHash = null,
        string $title = null,
        bool $active = false,
        ConversationStatus $conversationStatus = null
    ): ConversationInterface
    {
        $conversation = new ConversationDTO();
        $conversation
            ->setId($id ?? null)
            ->setAssistantId($assistantId ?? null)
            ->setConsultantId($consultantId ?? null)
            ->setSessionHash($sessionHash ?? null)
            ->setTitle($title ?? null)
            ->setActive($active ?? null)
            ->setConversationStatus($conversationStatus ?? ConversationStatus::ASSISTANT);

        return $conversation;
    }
}
