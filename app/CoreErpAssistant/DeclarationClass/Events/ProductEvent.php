<?php

namespace App\CoreErpAssistant\DeclarationClass\Events;

use App\CoreErpAssistant\Abstract\Event;
use App\CoreErpAssistant\Api\OpenAiApi;
use App\CoreErpAssistant\DeclarationClass\Events\Basic\NormalSQLEvent;
use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Enum\OpenAiModel;
use App\CoreErpAssistant\Prompts\OrderSQLPrompt;
use App\CoreErpAssistant\Prompts\ResponseUserPrompt;
use App\CoreErpAssistant\Service\Event\EventResult;
use Illuminate\Support\Facades\DB;

class ProductEvent extends NormalSQLEvent
{
    protected ?string $name = 'product';
    protected ?string $description = 'Pytania dotyczące zamówienia';
    protected array $triggers = ['produkty', 'produkt', 'zamówienie'];
}
