<?php

namespace App\Class\Message\Helper;

use App\Class\Message\Factory\MessageDTOFactory;
use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\MessageDTO;
use App\Class\PromptHistory\PromptHistoryDTO;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

final class MessageMapper
{

    public function __construct(
        private readonly MessageDTOFactory $messageDTOFactory
    )
    {
    }

    public function entityToDTO(Message $message): MessageInterface
    {
        $messageDTO = new MessageDTO();
        $messageDTO->setId($message->id)
            ->setContent($message->content)
            ->setSenderClass($message->senderClass)
            ->setSenderId($message->sender_id)
            ->setPromptHistory(new PromptHistoryDTO($message->prompt, $message->system))
            ->setConversionId($message->conversation_id)
            ->setUserId($message->user_id);

        return $this->messageDTOFactory->createMessageDTO(
            id: $message->id,
            conversationId: $message->conversation_id,
            content: $message->content,
            senderId: $message->sender_id,
            senderClass: $message->sender_class,
            prompt: $message->prompt,
            system: $message->system,
            userId: $message->user_id
        );
    }

    public function DTOToEntity(MessageInterface $messageDTO): Message
    {
        $message = new Message();
        $message->id = $messageDTO->getId() ?? null;
        $message->user_id = Auth::user()->id ?? null;
        $message->conversation_id = $messageDTO->getConversionId() ?? null;
        $message->content = $messageDTO->getContent() ?? null;
        $message->senderClass = $messageDTO->getSenderClass() ?? null;
        $message->sender_id = $messageDTO->getSenderId() ?? null;
        $message->prompt = $messageDTO->getPromptHistory()->getPrompt() ?? null;
        $message->system = $messageDTO->getPromptHistory()->getSystem() ?? null;

        return $message;
    }
}
