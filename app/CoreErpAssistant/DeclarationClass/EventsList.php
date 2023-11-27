<?php

namespace App\CoreErpAssistant\DeclarationClass;

use App\CoreErpAssistant\DeclarationClass\Events\ListOrderEvent;
use App\CoreErpAssistant\DeclarationClass\Events\OrderEvent;

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
            ListOrderEvent::class
        ];
    }
}
