<?php

namespace App\CoreAssistant\Service\Event;

use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Service\MessageInterpreter\InterpretationDetails;

class EventExecutor
{
    public function __construct(

    ){}

    public function executeEvent(InterpretationDetails $interpretationDetails, MessageProcessor $messageProcessor): EventResult
    {
        if($interpretationDetails->getInterpretedClass() !== null){
            $messageProcessor->getLoggerStep()->addStep([
                'interpretedClass' => $interpretationDetails->getInterpretedClass()::class
            ], 'EventExecutor - obsługa przez event');
            return $interpretationDetails->getInterpretedClass()->handle($messageProcessor);
        }

        $messageProcessor->getLoggerStep()->addStep([
            'interpretedClass' => null
        ], 'EventExecutor - normalna wiadomość');

        $result = new EventResult();
        $result->setMessageProcessor($messageProcessor);
        $result->setHandleWithEvent(false);

        return $result;
    }
}
