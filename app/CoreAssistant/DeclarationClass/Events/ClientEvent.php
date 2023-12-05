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

class ClientEvent extends NormalSQLEvent
{
    protected ?string $name = 'client';
    protected ?string $description = 'Pytania dotyczące klienta';
    protected array $triggers = ['klient', 'klienta', 'klientów'];


}
