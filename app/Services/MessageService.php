<?php

namespace App\Services;

use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\Assistant\Repository\AssistantRepository;
use App\Class\Conversation\Interface\ConversationInterface;
use App\Class\Message\Factory\MessageDTOFactory;
use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\Repository\MessageRepository;
use App\Class\PromptHistory\Prompt;
use App\Core\Class\Request\RequestDTO;
use App\Models\User;

class MessageService
{
    public function __construct(
        private readonly ConversationService $conversationService,
        private readonly MessageDTOFactory $messageDTOFactory,
        private readonly MessageRepository $messageRepository,
        private readonly AssistantRepository $assistantRepository
    )
    {
    }

    public function createMessageFromRequestDto(RequestDTO $requestDTO): MessageInterface|null
    {
        $conversation = $this->conversationService->getOrCreateConversationForNewMessage($requestDTO);

        $assistant = $this->assistantRepository->getAssistantById($requestDTO->getAssistantId());

        if($assistant !== null){
            $this->createFirstMessage($assistant, $conversation);
        }

        return $this->createMessage(
            conversationId: $conversation->getId(),
            content: $requestDTO->getMessage(),
            senderClass: User::class
        );
    }

    public function updatePromptHistory(MessageInterface $messageDTO, Prompt $prompt): bool
    {
        $messageDTO->setPromptHistory($prompt);
        return $this->messageRepository->save($messageDTO);
    }

    public function updateResultOpenAi(MessageInterface $messageDTO, string $resultOpenAiApi): bool
    {
        $messageDTO->setResult($resultOpenAiApi);
        return $this->messageRepository->save($messageDTO);
    }

    public function createMessage(
        int $id = null,
        int $conversationId = null,
        string $content = null,
        int $senderId = null,
        string $senderClass = null,
        array $urls = [],
        array $images = [],
        string $prompt = null,
        string $system = null,
        int $userId = null
    ): MessageInterface|null
    {
        $messageDTO = $this->messageDTOFactory->createMessageDTO(
            id: $id,
            conversationId: $conversationId,
            content: $content,
            senderId: $senderId,
            senderClass: $senderClass,
            urls: $urls,
            images: $images,
            prompt: $prompt,
            system: $system,
            userId: $userId
        );

        if ($this->messageRepository->save($messageDTO)) {
            return $messageDTO;
        }

        return null;
    }

    private function createFirstMessage(AssistantInterface $assistant, ConversationInterface $conversation): void
    {
        if($assistant->getStartMessage() !== null){
            $this->createMessage(
                conversationId: $conversation->getId(),
                content: $assistant->getStartMessage(),
                senderId: $assistant->getId(),
                senderClass: AssistantInterface::class
            );
        }
    }
}
