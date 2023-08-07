<?php

namespace App\Class\Message;

use App\Class\Message\Interface\MessageInterface;
use App\Class\PromptHistory\Prompt;
use App\Core\Abstract\Dto;

class MessageDTO extends Dto implements MessageInterface
{

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
     * @var Prompt|null The class with information about Using Prompt
     */
    private ?Prompt $promptHistory;

    /**
     * @var string|null The result of the message (result OpenAi).
     */
    private ?string $result;

    private ?string $links;

    /**
     * @param  Prompt|null  $promptHistory
     */
    public function __construct()
    {
        $this->promptHistory = new Prompt(null, null);
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
    public function setSenderId(int|null $senderId): self
    {
        $this->senderId = $senderId;
        return $this;
    }

    /**
     * Get the information about used Prompt
     * @return Prompt|null Information about used Prompt
     */
    public function getPromptHistory(): ?Prompt
    {
        return $this->promptHistory;
    }

    /**
     * Set Information about used Prompt
     * @param Prompt|null $promptHistory
     * @return self
     */
    public function setPromptHistory(Prompt|null $promptHistory): self
    {
        $this->promptHistory = $promptHistory;
        return $this;
    }

    /**
     * Get The result of the message (result OpenAi).
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     *  Set result of the message (result OpenAi).
     * @param  string|null  $result
     * @return $this
     */
    public function setResult(string|null $result): self
    {
        $this->result = $result;
        return $this;
    }

    public function getLinks(): ?string
    {
        return $this->links ?? null;
    }

    public function setLinks(?string $links): self
    {
        $this->links = $links;
        return $this;
    }

}
