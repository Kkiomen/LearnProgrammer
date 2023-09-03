<?php

namespace App\Core\Abstract;

use App\Core\Dto\EventData;
use App\Core\Dto\EventResponseDto;

abstract class Event
{
    protected ?string $name = null;
    protected ?string $description = null;
    protected array $triggers = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTriggers(): array
    {
        return $this->triggers ?? [];
    }

    abstract public function handle(EventData $eventData): EventResponseDto;
}
