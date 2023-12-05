<?php

namespace App\CoreAssistant\Domain\Message;

use App\CoreAssistant\Core\Domain\Abstract\Entity;

class Message extends Entity
{
    private ?int $userId = null;
    private ?int $conversationId = null;
    private ?string $userMessage = null;
    private ?string $senderClass = null;
    private ?int $senderId = null;
    private ?string $prompt = null;
    private ?string $system = null;
    private ?string $result = null;
    private ?string $steps = null;
    private ?string $table = null;
    private ?string $links = null;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getConversationId(): ?int
    {
        return $this->conversationId;
    }

    public function setConversationId(?int $conversationId): self
    {
        $this->conversationId = $conversationId;

        return $this;
    }

    public function getUserMessage(): ?string
    {
        return $this->userMessage;
    }

    public function setUserMessage(?string $userMessage): self
    {
        $this->userMessage = $userMessage;

        return $this;
    }

    public function getSenderClass(): ?string
    {
        return $this->senderClass;
    }

    public function setSenderClass(?string $senderClass): self
    {
        $this->senderClass = $senderClass;

        return $this;
    }

    public function getSenderId(): ?int
    {
        return $this->senderId;
    }

    public function setSenderId(?int $senderId): self
    {
        $this->senderId = $senderId;

        return $this;
    }

    public function getPrompt(): ?string
    {
        return $this->prompt;
    }

    public function setPrompt(?string $prompt): self
    {
        $this->prompt = $prompt;

        return $this;
    }

    public function getSystem(): ?string
    {
        return $this->system;
    }

    public function setSystem(?string $system): self
    {
        $this->system = $system;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getSteps(): ?string
    {
        return $this->steps;
    }

    public function setSteps(?string $steps): self
    {
        $this->steps = $steps;

        return $this;
    }

    public function getTable(): ?string
    {
        return $this->table;
    }

    public function setTable(?string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function getLinks(): ?string
    {
        return $this->links;
    }

    public function setLinks(?string $links): self
    {
        $this->links = $links;

        return $this;
    }
}
