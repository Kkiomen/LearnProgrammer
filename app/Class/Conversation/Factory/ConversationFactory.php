<?php

namespace App\Class\Conversation\Factory;

use App\Class\Conversation\ConversationDTO;
use App\Class\Conversation\Interface\ConversationInterface;

class ConversationFactory
{
    public function createConversationDTO(
        $id = null,
        $assistantId = null,
        $consultantId = null,
        $sessionHash = null,
        $title = null,
        $active = null,
        $conversationStatus = null
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
            ->setConversationStatus($conversationStatus ?? null);

        return $conversation;
    }
}
