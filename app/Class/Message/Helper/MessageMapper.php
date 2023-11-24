<?php

namespace App\Class\Message\Helper;

use App\Class\Message\Factory\MessageDTOFactory;
use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\MessageDTO;
use App\Class\PromptHistory\Prompt;
use App\Core\Abstract\Mapper;
use App\Core\Interfaces\DTOInterface;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class MessageMapper extends Mapper
{

    public function __construct(
        private readonly MessageDTOFactory $messageDTOFactory
    )
    {
    }

    public function mapToDTO(Message|Model $model): DTOInterface
    {
        return $this->messageDTOFactory->createMessageDTO(
            id: $model->id,
            conversationId: $model->conversation_id,
            content: $model->content,
            senderId: $model->sender_id,
            senderClass: $model->sender_class,
            prompt: $model->prompt,
            system: $model->system,
            userId: $model->user_id,
            result: $model->result,
            links: $model->links
        );
    }

    public function mapToModel(MessageInterface|DTOInterface $dtoClass): Model
    {
        $message = new Message();
        $message->id = $dtoClass->getId() ?? null;
        $message->user_id = Auth::user()->id ?? null;
        $message->conversation_id = $dtoClass->getConversionId() ?? null;
        $message->content = $dtoClass->getContent() ?? null;
        $message->sender_class = $dtoClass->getSenderClass() ?? null;
        $message->sender_id = $dtoClass->getSenderId() ?? null;
        $message->prompt = $dtoClass->getPromptHistory()->getPrompt() ?? null;
        $message->system = $dtoClass->getPromptHistory()->getSystem() ?? null;
        $message->result = $dtoClass->getResult() ?? null;
        $message->links = $dtoClass->getLinks() ?? null;

        return $message;
    }
}
