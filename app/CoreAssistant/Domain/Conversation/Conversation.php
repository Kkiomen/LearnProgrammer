<?php

namespace App\CoreAssistant\Domain\Conversation;

use App\CoreAssistant\Core\Domain\Abstract\Entity;
use App\CoreAssistant\Enum\ConversationStatus;

class Conversation extends Entity
{
    private ?int $userId = null;
    private ?int $assistantId = null;
    private ?int $consultantId = null;
    private ?string $sessionHash = null;
    private ?string $title = null;
    private ?bool $active = null;
    private ?ConversationStatus $status = null;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getAssistantId(): ?int
    {
        return $this->assistantId;
    }

    public function setAssistantId(?int $assistantId): self
    {
        $this->assistantId = $assistantId;

        return $this;
    }

    public function getConsultantId(): ?int
    {
        return $this->consultantId;
    }

    public function setConsultantId(?int $consultantId): self
    {
        $this->consultantId = $consultantId;

        return $this;
    }

    public function getSessionHash(): ?string
    {
        return $this->sessionHash;
    }

    public function setSessionHash(?string $sessionHash): self
    {
        $this->sessionHash = $sessionHash;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getStatus(): ?ConversationStatus
    {
        return $this->status;
    }

    public function setStatus(?ConversationStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
