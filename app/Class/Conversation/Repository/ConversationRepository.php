<?php

namespace App\Class\Conversation\Repository;

use App\Class\Conversation\Helper\ConversationMapper;
use App\Class\Conversation\Interface\ConversationInterface;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Collection;

class ConversationRepository
{

    public function __construct(
        private readonly ConversationMapper $conversationMapper
    )
    {
    }

    public function getConversationById(int|null $id, bool $toDto = true): Conversation|ConversationInterface|null
    {
        if($id === null){
            return null;
        }

        $conversation = Conversation::find($id);
        if($toDto){
            return $this->conversationMapper->mapToDTO($conversation);
        }

        return $conversation;
    }

    public function getConversationBySessionHash(string|null $sessionHash, bool $toDto = true): Conversation|ConversationInterface|null
    {
        if($sessionHash === null){
            return null;
        }

        $conversation = Conversation::where('session_hash', $sessionHash)->first();
        if($toDto){
            return $this->conversationMapper->mapToDTO($conversation);
        }

        return $conversation;
    }

    public function getConversationByAssistantId(int|null $assistantId, bool $toDto = true): Conversation|ConversationInterface|null
    {
        if($assistantId === null){
            return null;
        }

        $conversation = Conversation::where('assistant_id', $assistantId)->first();
        if($toDto){
            return $this->conversationMapper->mapToDTO($conversation);
        }

        return $conversation;
    }

    public function getConversationByConsultantId(int|null $consultantId, bool $toDto = true): Conversation|ConversationInterface|null
    {
        if($consultantId === null){
            return null;
        }

        $conversation = Conversation::where('consultant_id', $consultantId)->first();
        if($toDto){
            return $this->conversationMapper->mapToDTO($conversation);
        }

        return $conversation;
    }

    public function getConversationByCriteria(array $criteria, bool $toDto = true): Conversation|ConversationInterface|null
    {
        $conversation = Conversation::where($criteria)->first();
        if($toDto){
            return $this->conversationMapper->mapToDTO($conversation);
        }

        return $conversation;
    }

    public function getConversationsByCriteria(array $criteria, bool $toDto = true): Collection|null
    {
        $conversations = Conversation::where($criteria)->get();

        return $conversations;
    }


}
