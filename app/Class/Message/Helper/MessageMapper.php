<?php

namespace App\Class\Message\Helper;

use App\Class\Message\Factory\MessageDTOFactory;
use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\MessageDTO;
use App\Class\PromptHistory\PromptHistoryDTO;
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
        $messageDTO = new MessageDTO();
        $messageDTO->setId($model->id)
            ->setContent($model->content)
            ->setSenderClass($model->senderClass)
            ->setSenderId($model->sender_id)
            ->setPromptHistory(new PromptHistoryDTO($model->prompt, $model->system))
            ->setConversionId($model->conversation_id)
            ->setUserId($model->user_id);

        return $this->messageDTOFactory->createMessageDTO(
            id: $model->id,
            conversationId: $model->conversation_id,
            content: $model->content,
            senderId: $model->sender_id,
            senderClass: $model->sender_class,
            prompt: $model->prompt,
            system: $model->system,
            userId: $model->user_id
        );
    }

    public function mapCollectionToDTO(array $conversations): Collection
    {
        $collection = new Collection();
        foreach ($conversations as $conversation) {
            $collection->add($this->mapToDTO($conversation));
        }
        return $collection;
    }

    public function mapToModel(MessageInterface|DTOInterface $dtoClass): Model
    {
        $message = new Message();
        $message->id = $dtoClass->getId() ?? null;
        $message->user_id = Auth::user()->id ?? null;
        $message->conversation_id = $dtoClass->getConversionId() ?? null;
        $message->content = $dtoClass->getContent() ?? null;
        $message->senderClass = $dtoClass->getSenderClass() ?? null;
        $message->sender_id = $dtoClass->getSenderId() ?? null;
        $message->prompt = $dtoClass->getPromptHistory()->getPrompt() ?? null;
        $message->system = $dtoClass->getPromptHistory()->getSystem() ?? null;

        return $message;
    }
}
