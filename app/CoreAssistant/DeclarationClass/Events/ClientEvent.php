<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\DeclarationClass\Events\Basic\NormalSQLEvent;

class ClientEvent extends NormalSQLEvent
{
    protected ?string $name = 'client';
    protected ?string $description = 'Pytania dotyczące klienta';
    protected array $triggers = ['klient', 'klienta', 'klientów'];


}
