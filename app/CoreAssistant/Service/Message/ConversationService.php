<?php

namespace App\CoreAssistant\Service\Message;

use App\CoreAssistant\Adapter\Entity\Conversation\ConversationRepository;
use App\CoreAssistant\Adapter\Entity\Message\MessageRepository;
use App\CoreAssistant\Core\Collection\Collection;
use App\CoreAssistant\Core\Domain\Abstract\Entity;
use App\CoreAssistant\Domain\Conversation\Conversation;
use App\CoreAssistant\Domain\Message\Message;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;

class ConversationService
{
    public function __construct(
      private readonly ConversationRepository $conversationRepository,
      private readonly MessageRepository $messageRepository
    ){}

    public function createMessage(MessageProcessor $messageProcessor): Message|Entity
    {
        $conversation = $this->getOrCreateConversations($messageProcessor->getSessionHash());

        $message = new Message();
        $message->setConversationId($conversation->getId());

        return $this->messageRepository->save($message);
    }


    public function getOrCreateConversations(string $sessionHash): Conversation|Entity
    {
        $conversation = $this->conversationRepository->findOneBy(['session_hash' => $sessionHash]);

        if($conversation){
            return $conversation;
        }

        $conversation = new Conversation();
        $conversation->setSessionHash($sessionHash);
        return $this->conversationRepository->save($conversation);
    }

    public function getConversationMessages(?string $sessionHash): Collection
    {
        $conversation = $this->conversationRepository->findBy(['session_hash' => $sessionHash]);

        if($conversation){
            return $conversation;
        }

        return new Collection();
    }

    public function isExistsConversationBySessionHash(string $sessionHash): bool
    {
        return $this->conversationRepository->exists(['session_hash' => $sessionHash]);
    }
}
