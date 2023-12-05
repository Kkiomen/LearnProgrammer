<?php

namespace App\CoreAssistant\DeclarationClass;

use App\CoreAssistant\DeclarationClass\Events\ClientEvent;
use App\CoreAssistant\DeclarationClass\Events\ListOrderEvent;
use App\CoreAssistant\DeclarationClass\Events\OrderEvent;
use App\CoreAssistant\DeclarationClass\Events\ProductEvent;

class EventsList
{
    /**
     * List of all functionality
     * @return array
     */
    public function getList(): array
    {
        return [
            OrderEvent::class,
            ListOrderEvent::class,
            ClientEvent::class,
            ProductEvent::class
        ];
    }
}
