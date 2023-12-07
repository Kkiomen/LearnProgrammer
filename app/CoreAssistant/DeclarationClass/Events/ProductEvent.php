<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\DeclarationClass\Events\Basic\NormalSQLEvent;

class ProductEvent extends NormalSQLEvent
{
    protected ?string $name = 'product';
    protected ?string $description = 'Pytania dotyczące zamówienia';
    protected array $triggers = ['produkty', 'produkt', 'zamówienie'];
}
