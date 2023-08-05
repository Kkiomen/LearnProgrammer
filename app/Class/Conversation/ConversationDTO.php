<?php

namespace App\Class\Conversation;

use App\Class\Conversation\Enum\ConversationStatus;
use App\Class\Conversation\Interface\ConversationInterface;
use App\Core\Abstract\Dto;

class ConversationDTO extends Dto implements ConversationInterface
{

    /**
     * @var ?int ID of the assistant
     */
    private ?int $assistantId;

    /**
     * @var ?int ID of the consultant
     */
    private ?int $consultant_id;

    /**
     * @var ?string Hash of the session
     */
    private ?string $sessionHash;

    /**
     * @var ?string Title of the conversation
     */
    private ?string $title;

    /**
     * @var bool Indicates if the conversation is active or not
     */
    private bool $active;

    /**
     * @var ConversationStatus Status of the conversation
     */
    private ConversationStatus $conversationStatus;

    /**
     * Get the assistant's ID
     *
     * @return ?int
     */
    public function getAssistantId(): ?int
    {
        return $this->assistantId;
    }

    /**
     * Set the assistant's ID
     *
     * @param ?int $assistantId
     * @return ConversationDTO
     */
    public function setAssistantId(?int $assistantId): self
    {
        $this->assistantId = $assistantId;
        return $this;
    }

    /**
     * Get the consultant's ID
     *
     * @return ?int
     */
    public function getConsultantId(): ?int
    {
        return $this->consultant_id;
    }

    /**
     * Set the consultant's ID
     *
     * @param ?int $consultant_id
     * @return ConversationDTO
     */
    public function setConsultantId(?int $consultant_id): self
    {
        $this->consultant_id = $consultant_id;
        return $this;
    }

    /**
     * Get the session hash
     *
     * @return ?string
     */
    public function getSessionHash(): ?string
    {
        return $this->sessionHash;
    }

    /**
     * Set the session hash
     *
     * @param ?string $sessionHash
     * @return ConversationDTO
     */
    public function setSessionHash(?string $sessionHash): self
    {
        $this->sessionHash = $sessionHash;
        return $this;
    }

    /**
     * Get the title of the conversation
     *
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title of the conversation
     *
     * @param ?string $title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the active status of the conversation
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Set the active status of the conversation
     *
     * @param bool $active
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get the conversation status
     *
     * @return ConversationStatus
     */
    public function getConversationStatus(): ConversationStatus
    {
        return $this->conversationStatus;
    }

    /**
     * Set the conversation status
     *
     * @param ConversationStatus $conversationStatus
     */
    public function setConversationStatus(ConversationStatus $conversationStatus): self
    {
        $this->conversationStatus = $conversationStatus;
        return $this;
    }
}
