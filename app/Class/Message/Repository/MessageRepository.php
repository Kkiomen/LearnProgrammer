<?php

namespace App\Class\Message\Repository;

use App\Class\Message\Helper\MessageMapper;
use App\Class\Message\Interface\MessageInterface;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class MessageRepository
{
    public function __construct(
        private readonly MessageMapper $messageMapper,
    )
    {
    }

    /**
     * Save the provided message.
     *
     * @param MessageInterface $messageDTO The message to save
     * @return void
     */
    public function save(MessageInterface $messageDTO){
        $message = $this->messageMapper->DTOToEntity($messageDTO);
        $message->save();
    }

    /**
     * Get all messages.
     *
     * @return Collection Collection of all messages
     */
    public function getAll(): Collection
    {
        return Message::all();
    }

    public function findAllForUser(array|null $criteria, bool $toDto = false): Collection|null
    {
        if($criteria === null){
            return null;
        }

        return Message::where('user_id', Auth::user()->id)->get();
    }

    /**
     * Find messages by criteria.
     *
     * @param array|null $criteria The criteria to search by
     * @param bool $toDto Whether to convert the result to DTO (not used in current method, but included for consistency)
     * @return Collection|null Collection of found messages or null if criteria is not provided
     */
    public function findBy(array|null $criteria, bool $toDto = false): Collection|null
    {
        if($criteria === null){
            return null;
        }

        return Message::where($criteria)->get();
    }

    /**
     * Find one message by criteria.
     *
     * @param array|null $criteria The criteria to search by
     * @param bool $toDto Whether to convert the result to DTO
     * @return Message|MessageInterface|null The found message or null if not found
     */
    public function findOneBy(array|null $criteria, bool $toDto = false): Message|MessageInterface|null
    {
        if($criteria === null){
            return null;
        }

        $entity = Message::where($criteria)->first();
        if($toDto){
            return $this->messageMapper->entityToDTO($entity);
        }

        return $entity;
    }

    /**
     * Find one message by id.
     *
     * @param int|null $id The id to search by
     * @param bool $toDto Whether to convert the result to DTO
     * @return Message|MessageInterface|null The found message or null if not found
     */
    public function findOneById(int|null $id, bool $toDto = false): Message|MessageInterface|null
    {
        if($id === null){
            return null;
        }

        $entity = Message::where('id', $id)->first();
        if($toDto){
            return $this->messageMapper->entityToDTO($entity);
        }

        return $entity;
    }
}
