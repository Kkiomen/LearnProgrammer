<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\Config\TableToPrompts\TablePrompt;
use App\CoreAssistant\DeclarationClass\Events\Basic\NormalSQLEvent;

class ProductEvent extends NormalSQLEvent
{
    protected ?string $name = 'product';
    protected ?string $description = 'Pytania dotyczące zamówienia';
    protected array $triggers = ['produkty', 'produkt', 'zamówienie'];
    protected array $tableListToPrompt = [
        TablePrompt::CLIENTS,
        TablePrompt::PRODUCTS,
        TablePrompt::INVOICES,
        TablePrompt::INVOICE_POSITIONS
    ];
}
