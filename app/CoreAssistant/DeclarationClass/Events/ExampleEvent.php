<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\Abstract\Event;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Service\Event\EventResult;

class ExampleEvent extends Event
{

    protected ?string $name = 'save';
    protected ?string $description = 'save/remember information in memory';
    protected array $triggers = ['zapisz', 'zapamiętaj', 'zapamietaj', 'save', 'store', 'remember'];


    public function handle(MessageProcessor $messageProcessor): EventResult
    {
        // TODO: Implement handle() method.

        return new EventResult();
    }
}
