<?php

namespace App\Class\Conversation\Repository;

use App\Class\Conversation\Helper\ConversationMapper;
use App\Class\Conversation\Interface\ConversationInterface;
use App\Class\Message\Repository\MessageRepository;
use App\Core\Interfaces\DTOInterface;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ConversationRepository
{

    public function __construct(
        private readonly ConversationMapper $conversationMapper,
        private readonly MessageRepository $messageRepository
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

    public function getConversationBySessionHash(string|null $sessionHash, bool $toDto = true, bool $isActive = false): DTOInterface|null
    {
        if($sessionHash === null){
            return null;
        }

        if($isActive) {
            $conversation = Conversation::where('session_hash', $sessionHash)->where('active', true)->first();
        }else{
            $conversation = Conversation::where('session_hash', $sessionHash)->first();
        }
        if($toDto && $conversation !== null){
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

    public function getNewSessionHashConversation(): string
    {
        do{
            $uuid = (string) Str::uuid();
        }while($this->getConversationBySessionHash($uuid) !== null);

        return $uuid;
    }

    public function getMessagesBySessionHash(string $sessionHash): array|\Illuminate\Support\Collection
    {
        $conversation = $this->getConversationBySessionHash($sessionHash);
        if($conversation === null){
            return [];
        }

        return $this->messageRepository->getMessagesByConversationId($conversation->getId());
    }


    public function save(ConversationInterface &$conversation): bool
    {
        $conversationModel = $this->conversationMapper->mapToModel($conversation);
        $existingConversationModel = Conversation::find($conversationModel->id);

        if($existingConversationModel){
            // Update existing conversation
            $existingConversationModel->update($conversationModel->getAttributes());
            return true;
        } else {
            // Save new message
            if ($conversationModel->save()) {
                // Set the id of the DTO to the id of the saved model
                $conversationModel->setId($conversationModel->id);
                return true;
            }
        }

        return false;
    }


}
