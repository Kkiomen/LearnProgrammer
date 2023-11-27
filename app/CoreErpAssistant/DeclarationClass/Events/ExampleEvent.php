<?php

namespace App\CoreErpAssistant\DeclarationClass\Events;

use App\CoreErpAssistant\Abstract\Event;
use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Service\Event\EventResult;

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
