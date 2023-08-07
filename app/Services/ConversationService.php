<?php

namespace App\Services;

use App\Class\Conversation\Enum\ConversationStatus;
use App\Class\Conversation\Factory\ConversationFactory;
use App\Class\Conversation\Interface\ConversationInterface;
use App\Class\Conversation\Repository\ConversationRepository;
use App\Class\Message\Interface\MessageInterface;
use App\Core\Class\Request\RequestDTO;
use App\Core\Interfaces\DTOInterface;

class ConversationService
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
        private readonly ConversationFactory $conversationFactory
    ) {
    }

    public function clearConversation(string $sessionHash): bool
    {
        return $this->conversationRepository->unActiveBySessionHash($sessionHash);
    }

    public function getOrCreateConversationForNewMessage(RequestDTO $requestDTO): ConversationInterface
    {
        if($requestDTO->getSessionHash() !== null){
            $conversation = $this->getConversation(null, $requestDTO->getSessionHash(), true);
        }
        if(!$conversation || $conversation === null){
            $conversation = $this->createConversation(
                assistantId: $requestDTO->getAssistantId(),
                consultantId: $requestDTO->getConsultantId(),
                sessionHash: $requestDTO->getSessionHash(),
                active: true,
                conversationStatus: ConversationStatus::ASSISTANT);
        }
        return $conversation;
    }

    public function getConversation(?int $id, ?string $sessionHash = null, bool $mustBeActive = false): ConversationInterface|DTOInterface|null
    {
        if ($id !== null) {
            return $this->conversationRepository->getConversationById($id);
        }

        if ($sessionHash !== null) {
            return $this->conversationRepository->getConversationBySessionHash($sessionHash, $mustBeActive);
        }

        return null;
    }

    public function createConversation(
        int $id = null,
        int $assistantId = null,
        int $consultantId = null,
        string $sessionHash = null,
        string $title = null,
        bool $active = false,
        ConversationStatus $conversationStatus = null): ConversationInterface|null
    {
        $conversationDTO = $this->conversationFactory->createConversationDTO(
            id: $id,
            assistantId: $assistantId,
            consultantId: $consultantId,
            sessionHash: $sessionHash,
            title: $title,
            active: $active,
            conversationStatus: $conversationStatus
        );

        if ($this->conversationRepository->save($conversationDTO)) {
            return $conversationDTO;
        }

        return null;
    }

    public function getMessagesForView(string|null $sessionHash): array
    {
        $result = [];

        if($sessionHash === null){
            return [];
        }

        $messages = $this->conversationRepository->getMessagesBySessionHash($sessionHash);

        /**
         * @var MessageInterface $message
         */
        foreach ($messages as $message){
            if($message->getResult() !== null){
                $result[] = [
                    'sender' => 'user',
                    'content' => $message->getContent(),

                ];

                $ai = [
                    'sender' => 'assistant',
                    'content' => $message->getResult(),

                ];

                if(!empty($message->getLinks())){
                    $result[] = array_merge($ai, ['links' => explode(';', $message->getLinks()) ?? []]);
                }else{
                    $result[] = $ai;
                }
            }

        }

        return $result;
    }
}
