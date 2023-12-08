<?php

namespace App\CoreAssistant\Adapter\Entity\Message;

use App\CoreAssistant\Adapter\Repository\EloquentRepository\EloquentRepository;
use App\CoreAssistant\Core\Domain\Abstract\Entity;
use App\CoreAssistant\Domain\Message\MessageBuilder;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MessageEloquentRepository extends EloquentRepository implements MessageRepository
{
    protected ?string $model = Message::class;

    function mapModelToEntity(Model $model): Entity
    {
        $messageBuilder = new MessageBuilder();
        $messageBuilder
            ->setId($model->id)
            ->setUserId($model->user_id)
            ->setConversationId($model->conversation_id)
            ->setUserMessage($model->user_message)
            ->setSenderClass($model->sender_class)
            ->setSenderId($model->sender_id)
            ->setPrompt($model->prompt)
            ->setSystem($model->system)
            ->setResult($model->result)
            ->setSteps($model->steps)
            ->setQueries($model->queries)
            ->setTable($model->table)
            ->setLinks($model->links)
            ->setCreatedAt($model->created_at->toDateTime())
            ->setUpdatedAt($model->updated_at->toDateTime());

        return $messageBuilder->build();
    }

    function mapEntityToModel(Entity $entity): Model
    {
        if($entity->getId() !== null){
            $message = $this->getOrCreateModel($entity->getId());
        }else{
            $message = new Message();
        }

        $message->user_id = $entity->getUserId();
        $message->conversation_id = $entity->getConversationId();
        $message->user_message = $entity->getUserMessage();
        $message->sender_class = $entity->getSenderClass();
        $message->sender_id = $entity->getSenderId();
        $message->prompt = $entity->getPrompt();
        $message->system = $entity->getSystem();
        $message->result = $entity->getResult();
        $message->steps = $entity->getSteps();
        $message->table = $entity->getTable();
        $message->queries = $entity->getQueries();
        $message->links = $entity->getLinks();

        $createdAt = Carbon::instance($entity->getCreatedAt() ?? new \DateTime());
        $message->created_at = $createdAt;

        $updateAt = Carbon::instance($entity->getUpdatedAt() ?? new \DateTime());
        $message->created_at = $updateAt;

        return $message;
    }
}
