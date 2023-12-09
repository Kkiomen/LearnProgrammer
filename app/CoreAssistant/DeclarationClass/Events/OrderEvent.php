<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\Config\TableToPrompts\TablePrompt;
use App\CoreAssistant\DeclarationClass\Events\Basic\NormalSQLEvent;

class OrderEvent extends NormalSQLEvent
{
    protected ?string $name = 'order';
    protected ?string $description = 'Pytania dotyczące zamówienia';
    protected array $triggers = ['zamówień', 'zamówienia', 'zamówienie', 'zamówieniu'];
    protected array $tableListToPrompt = [
        TablePrompt::CLIENTS,
        TablePrompt::PRODUCTS,
        TablePrompt::INVOICES,
        TablePrompt::INVOICE_POSITIONS
    ];
}
