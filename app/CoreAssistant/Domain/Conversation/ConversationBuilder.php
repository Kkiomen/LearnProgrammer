<?php

namespace App\CoreAssistant\Domain\Conversation;

use App\CoreAssistant\Core\Domain\Abstract\Entity;
use App\CoreAssistant\Core\Patterns\Builder\BuilderEntity;
use App\CoreAssistant\Enum\ConversationStatus;

class ConversationBuilder implements BuilderEntity
{
    private Conversation $conversation;

    public function __construct()
    {
        $this->conversation = new Conversation();
    }

    public function setId(?int $id): self
    {
        $this->conversation->setId($id);

        return $this;
    }

    public function setUserId(?int $userId): self
    {
        $this->conversation->setUserId($userId);

        return $this;
    }

    public function setAssistantId(?int $assistantId): self
    {
        $this->conversation->setAssistantId($assistantId);

        return $this;
    }

    public function setConsultantId(?int $consultantId): self
    {
        $this->conversation->setConsultantId($consultantId);

        return $this;
    }

    public function setSessionHash(?string $sessionHash): self
    {
        $this->conversation->setSessionHash($sessionHash);

        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->conversation->setTitle($title);

        return $this;
    }

    public function setActive(?bool $active): self
    {
        $this->conversation->setActive($active);

        return $this;
    }

    public function setStatus(?ConversationStatus $status): self
    {
        $this->conversation->setStatus($status);

        return $this;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->conversation->setCreatedAt($createdAt);

        return $this;
    }

    public function setUpdatedAt(?\DateTime $updateAt): self
    {
        $this->conversation->setUpdatedAt($updateAt);

        return $this;
    }

    public function reset(): void
    {
        $this->conversation = new Conversation();
    }

    public function build(): Entity
    {
        return $this->conversation;
    }
}
