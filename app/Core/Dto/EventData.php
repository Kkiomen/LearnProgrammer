<?php

namespace App\Core\Dto;

use App\Class\Assistant\Interface\AssistantInterface;

/**
 * Class used to transfer information to the Event class
 */
class EventData
{
    private ?string $content = null;
    private array $data = [];

    private ?string $eventName = null;

    private ?int $assistantId = null;

    public function getData(): array
    {
        return $this->data;
    }
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(?string $eventName): self
    {
        $this->eventName = $eventName;
        return $this;
    }

    public function getAssistantId(): ?int
    {
        return $this->assistantId;
    }

    public function setAssistantId(int $assistant): self
    {
        $this->assistantId = $assistant;
        return $this;
    }


}
