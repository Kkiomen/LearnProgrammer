<?php

namespace App\Strategy\Message;

use App\Abstract\Message;
use App\Abstract\MessageData;
use App\Enum\TypeMessage;
use App\Services\CommandInvoker;

class CommandMessage extends Message
{
    protected TypeMessage $typeMessage = TypeMessage::COMMAND;
    private CommandInvoker $commandInvoker;

    public function __construct(MessageData $messageData)
    {
        parent::__construct($messageData);
        $this->commandInvoker = app(CommandInvoker::class);
    }

    public function prepareData(array $payload): array
    {
        return [];
    }

    public function getResult(): array
    {
        $resultCommand = $this->commandInvoker->executeCommand($this->messageData->message);
        $this->messageData->saveResult($resultCommand['message']);

        return [
            'fullResponse' => true,
            'message' => $resultCommand['message'],
            'data' => $resultCommand['data'] ?? null
        ];
    }
}
