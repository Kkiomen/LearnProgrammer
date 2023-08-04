<?php

namespace App\Class\Message;

use App\Class\Message\Interface\MessageInterface;
use App\Class\PromptHistory\PromptHistoryDTO;

class MessageDTO implements MessageInterface
{
    /**
     * @var int|null The ID of the message.
     */
    private ?int $id;

    /**
     * @var int|null The ID of the conversion.
     */
    private ?int $conversationId;

    /**
     * @var int|null The ID of the user.
     */
    private ?int $userId;

    /**
     * @var string|null The content of the message.
     */
    private ?string $content;

    /**
     * @var string|null The class of the sender.
     */
    private ?string $senderClass;

    /**
     * @var int|null The ID of the sender.
     */
    private ?int $senderId;

    /**
     * @var PromptHistoryDTO|null The class with information about Using Prompt
     */
    private ?PromptHistoryDTO $promptHistory;

    /**
     * Get the ID of the message.
     *
     * @return int|null The ID of the message.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the ID of the message.
     *
     * @param int|null $id The ID to set for the message.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the id of the conversation.
     *
     * @return int|null The id of the conversation.
     */
    public function getConversionId(): ?int
    {
        return $this->conversationId;
    }

    /**
     * Set the id of the conversation.
     *
     * @param int|null $conversationId The id of the conversation
     * @return self Returns an instance of the MessageDTO.
     */
    public function setConversionId(?int $conversationId): self
    {
        $this->conversationId = $conversationId;
        return $this;
    }

    /**
     * Get the id of the user.
     *
     * @return int|null The id of the user.
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Set the id of the user.
     *
     * @param int|null $userId The id of the user
     * @return self Returns an instance of the MessageDTO.
     */
    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get the content of the message.
     *
     * @return string|null The content of the message.
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the content of the message.
     *
     * @param string|null $content The content to set for the message.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get the class of the sender.
     *
     * @return string|null The class of the sender.
     */
    public function getSenderClass(): ?string
    {
        return $this->senderClass;
    }

    /**
     * Set the class of the sender.
     *
     * @param string|null $senderClass The class to set for the sender.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setSenderClass(?string $senderClass): self
    {
        $this->senderClass = $senderClass;
        return $this;
    }

    /**
     * Get the ID of the sender.
     *
     * @return int|null The ID of the sender.
     */
    public function getSenderId(): ?int
    {
        return $this->senderId;
    }

    /**
     * Set the ID of the sender.
     *
     * @param int|null $senderId The ID to set for the sender.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setSenderId(?int $senderId): self
    {
        $this->senderId = $senderId;
        return $this;
    }

    /**
     * Get the information about used Prompt
     * @return PromptHistoryDTO|null Information about used Prompt
     */
    public function getPromptHistory(): ?PromptHistoryDTO
    {
        return $this->promptHistory;
    }

    /**
     * Set Information about used Prompt
     * @param PromptHistoryDTO|null $promptHistory
     * @return self
     */
    public function setPromptHistory(?PromptHistoryDTO $promptHistory): self
    {
        $this->promptHistory = $promptHistory;
        return $this;
    }
}
