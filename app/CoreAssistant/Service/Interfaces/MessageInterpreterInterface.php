<?php

namespace App\CoreAssistant\Service\Interfaces;

use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Service\MessageInterpreter\InterpretationDetails;

interface MessageInterpreterInterface
{
    public function interpretMessage(MessageProcessor $messageProcessor): InterpretationDetails;
}
