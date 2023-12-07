<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\DeclarationClass\Events\Basic\NormalSQLEvent;

class OrderEvent extends NormalSQLEvent
{
    protected ?string $name = 'order';
    protected ?string $description = 'Pytania dotyczące zamówienia';
    protected array $triggers = ['zamówień', 'zamówienia', 'zamówienie', 'zamówieniu'];
}
