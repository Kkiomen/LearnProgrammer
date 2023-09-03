<?php

namespace App\Core\Event;

use App\Core\Abstract\EventDispatcher;
use App\Core\Event\Events\CalendarEvent;
use App\Core\Event\Events\SaveEvent;

class EventHandler extends EventDispatcher
{
    /**
     * List of all events
     * @return array
     */
    protected function getListEvents(): array
    {
        return [
            SaveEvent::class,
            CalendarEvent::class,
        ];
    }
}
