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

    /**
     * Creates a message from a RequestDTO.
     *
     * @param RequestDTO $requestDTO
     * @return MessageInterface|null
     */
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

    /**
     * Updates the prompt history associated with a message.
     *
     * @param MessageInterface $messageDTO
     * @param Prompt $prompt
     * @return bool
     */
    public function updatePromptHistory(MessageInterface $messageDTO, Prompt $prompt): bool
    {
        $messageDTO->setPromptHistory($prompt);
        return $this->messageRepository->save($messageDTO);
    }

    /**
     * Updates the OpenAI API result associated with a message.
     *
     * @param MessageInterface $messageDTO
     * @param string $resultOpenAiApi
     * @return bool
     */
    public function updateResultOpenAi(MessageInterface $messageDTO, string $resultOpenAiApi): bool
    {
        $messageDTO->setResult($resultOpenAiApi);
        return $this->messageRepository->save($messageDTO);
    }

    /**
     * Creates a message.
     *
     * @param int|null $id
     * @param int|null $conversationId
     * @param string|null $content
     * @param int|null $senderId
     * @param string|null $senderClass
     * @param array $urls
     * @param array $images
     * @param string|null $prompt
     * @param string|null $system
     * @param int|null $userId
     * @return MessageInterface|null
     */
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

    /**
     * Creates the first message in a conversation if an assistant has a start message.
     *
     * @param AssistantInterface $assistant
     * @param ConversationInterface $conversation
     */
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
