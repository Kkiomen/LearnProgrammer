<?php

namespace App\Core\Dto;

class EventResponseDto
{
    private ?string $content = null;
    private array $data = [];
    private string $eventName;

    private bool $changedContent = false;

    public function __construct(string $eventName)
    {
        $this->eventName = $eventName;
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

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;
        return $this;
    }

    public function isChangedContent(): bool
    {
        return $this->changedContent;
    }

    public function setChangedContent(bool $changedContent): self
    {
        $this->changedContent = $changedContent;
        return $this;
    }

}
