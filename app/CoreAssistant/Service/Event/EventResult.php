<?php

namespace App\CoreAssistant\Service\Event;

use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Prompts\ResponseUserPrompt;

class EventResult
{
    private ?bool $handleWithEvent = false;

    private ?MessageProcessor $messageProcessor = null;

    private ?string $resultResponseSystemPrompt = null;

    private ?string $resultResponseUserMessage = null;

    private ?float $resultResponseTemperature = null;

    private ?array $resultResponseTable = null;


    public function setResultResponseSystemPrompt(?string $resultResponseSystemPrompt): self
    {
        $this->resultResponseSystemPrompt = $resultResponseSystemPrompt;

        return $this;
    }

    public function getResultResponseSystemPrompt(): string
    {
        $result = $this->resultResponseSystemPrompt;

        if($result === null){
            $question = $this->messageProcessor->getMessageFromUser() ?? '';
            $result = ResponseUserPrompt::getPrompt($question, '', '');
        }

        return $result;
    }

    public function setMessageProcessor(?MessageProcessor $messageProcessor): self
    {
        $this->messageProcessor = $messageProcessor;

        return $this;
    }

    public function getMessageProcessor(): ?MessageProcessor
    {
        return $this->messageProcessor;
    }

    public function getHandleWithEvent(): ?bool
    {
        return $this->handleWithEvent;
    }

    public function setHandleWithEvent(?bool $handleWithEvent): self
    {
        $this->handleWithEvent = $handleWithEvent;

        return $this;
    }

    public function getResultResponseUserMessage(): ?string
    {
        return $this->resultResponseUserMessage;
    }

    public function setResultResponseUserMessage(?string $resultResponseUserMessage): self
    {
        $this->resultResponseUserMessage = $resultResponseUserMessage;

        return $this;
    }

    public function getResultResponseTemperature(): ?float
    {
        return $this->resultResponseTemperature;
    }

    public function setResultResponseTemperature(?float $resultResponseTemperature): self
    {
        $this->resultResponseTemperature = $resultResponseTemperature;

        return $this;
    }

    public function getResultResponseTable(): ?array
    {
        return $this->resultResponseTable ?? [];
    }

    public function setResultResponseTable(?array $resultResponseTable): self
    {
        $this->resultResponseTable = $resultResponseTable;

        return $this;
    }
}
