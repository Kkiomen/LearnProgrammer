<?php

namespace App\CoreAssistant\Adapter\Entity\Conversation;

use App\Class\Assistant\Enum\AssistantType;
use App\CoreAssistant\Adapter\Repository\EloquentRepository\EloquentRepository;
use App\CoreAssistant\Core\Domain\Abstract\Entity;
use App\CoreAssistant\Domain\Conversation\ConversationBuilder;
use App\CoreAssistant\Enum\ConversationStatus;
use App\Models\Conversation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConversationEloquentRepository extends EloquentRepository implements ConversationRepository
{
    protected ?string $model = Conversation::class;

    function mapModelToEntity(Model $model): Entity
    {
        $conversationBuilder = new ConversationBuilder();
        $conversationBuilder
            ->setId($model->id)
            ->setUserId($model->user_id)
            ->setConsultantId($model->consultant_id)
            ->setSessionHash($model->session_hash)
            ->setTitle($model->title)
            ->setActive($model->active)
            ->setStatus(AssistantType::tryFrom($model->status) ?? null)
            ->setCreatedAt($model->created_at->toDateTime())
            ->setUpdatedAt($model->updated_at->toDateTime());

        return $conversationBuilder->build();
    }

    function mapEntityToModel(\App\CoreAssistant\Domain\Conversation\Conversation|Entity $entity): Model
    {
        $conversation = $this->getOrCreateModel($entity->getId());
        $conversation->user_id = $entity->getUserId();
        $conversation->assistant_id = $entity->getAssistantId();
        $conversation->consultant_id = $entity->getConsultantId();
        $conversation->session_hash = $entity->getSessionHash();
        $conversation->title = $entity->getTitle();
        $conversation->active = $entity->getActive();
        $conversation->status = !empty($entity->getStatus()) ? $entity->getStatus()->value : ConversationStatus::ASSISTANT->value;

        $createdAt = Carbon::instance($entity->getCreatedAt() ?? new \DateTime());
        $conversation->created_at = $createdAt;

        $updateAt = Carbon::instance($entity->getUpdatedAt() ?? new \DateTime());
        $conversation->created_at = $updateAt;

        return $conversation;
    }
}
