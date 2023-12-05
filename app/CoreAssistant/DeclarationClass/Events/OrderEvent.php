<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\Abstract\Event;
use App\CoreAssistant\Api\OpenAiApi;
use App\CoreAssistant\DeclarationClass\Events\Basic\NormalSQLEvent;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Enum\OpenAiModel;
use App\CoreAssistant\Prompts\OrderSQLPrompt;
use App\CoreAssistant\Prompts\ResponseUserPrompt;
use App\CoreAssistant\Service\Event\EventResult;
use Illuminate\Support\Facades\DB;

class OrderEvent extends NormalSQLEvent
{
    protected ?string $name = 'order';
    protected ?string $description = 'Pytania dotyczące zamówienia';
    protected array $triggers = ['zamówień', 'zamówienia', 'zamówienie', 'zamówieniu'];
}
