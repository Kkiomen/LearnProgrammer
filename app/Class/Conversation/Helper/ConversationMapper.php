<?php

namespace App\Class\Conversation\Helper;

use App\Class\Conversation\Factory\ConversationFactory;
use App\Core\Abstract\Mapper;
use App\Core\Interfaces\DTOInterface;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Model;

final class ConversationMapper extends Mapper
{

    public function __construct(
        private readonly ConversationFactory $conversationFactory
    )
    {
    }

    public function mapToDTO(Model $model): DTOInterface
    {
        return $this->conversationFactory->createConversationDTO(
            $model['id'],
            $model['assistant_id'],
            $model['consultant_id'],
            $model['session_hash'],
            $model['title'],
            $model['active'],
            $model['conversation_status']
        );
    }

    public function mapToModel(DTOInterface $dtoClass): Model
    {
        return new Conversation([
            'id' => $dtoClass->getId(),
            'assistant_id' => $dtoClass->getAssistantId(),
            'consultant_id' => $dtoClass->getConsultantId(),
            'session_hash' => $dtoClass->getSessionHash(),
            'title' => $dtoClass->getTitle(),
            'active' => $dtoClass->isActive(),
            'conversation_status' => $dtoClass->getConversationStatus()
        ]);
    }
}
