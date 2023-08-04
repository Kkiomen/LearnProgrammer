<?php

namespace App\Abstract;

use App\Enum\TypeMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class Message
{
    protected MessageData $messageData;

    protected TypeMessage $typeMessage = TypeMessage::TEXT;

    /**
     * @param MessageData $messageData
     */
    public function __construct(MessageData &$messageData)
    {
        $this->messageData = $messageData;
        $this->assignmentTypeMessage();
    }


    public abstract function prepareData(array $payload): array;
    public abstract function getResult(): array;


    /**
     * Assigning the right type of message
     * @return void
     */
    private function assignmentTypeMessage(): void
    {
        $this->messageData->typeMessage = $this->typeMessage->value;
        $this->messageData->messageModel->type = $this->typeMessage->value;
    }
}
