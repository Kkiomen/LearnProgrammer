<?php

namespace App\CoreErpAssistant\Service\Interfaces;

use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Service\MessageInterpreter\InterpretationDetails;

interface MessageInterpreterInterface
{
    public function interpretMessage(MessageProcessor $messageProcessor): InterpretationDetails;
}
