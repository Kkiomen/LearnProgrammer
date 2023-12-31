<?php

namespace App\Core\Abstract;

use App\Core\Core\Dto\EventData;
use App\Core\Core\Dto\EventResponseDto;

abstract class Event
{
    /**
     * @var string|null $name The name of the event
     * @example 'calendar'
     */
    protected ?string $name = null;

    /**
     * @var string|null $description A brief description of the event. Based on this variable, an event is selected
     * @example 'adding an event to the calendar and only adds the event'
     */
    protected ?string $description = null;

    /**
     * @var array $triggers List of triggers to initiate the event
     * @example ['calendar', 'event']
     */
    protected array $triggers = [];

    /**
     * @return string|null The name of the event
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null A brief description of the event. Based on this variable, an event is selected
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array List of triggers to initiate the event
     */
    public function getTriggers(): array
    {
        return $this->triggers ?? [];
    }

    /**
     * Handle the event.
     *
     * @param EventData $eventData Data related to the event
     * @return EventResponseDto Response after handling the event
     */
    abstract public function handle(EventData $eventData): EventResponseDto;
}
