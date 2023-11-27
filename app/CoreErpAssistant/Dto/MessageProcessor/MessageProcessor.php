<?php

namespace App\CoreErpAssistant\Dto\MessageProcessor;

use App\CoreErpAssistant\Dto\MessageProcessor\LoggerStep\LoggerSteps;

class MessageProcessor
{
    private ?string $messageFromUser = null;
    private string $systemPrompt;
    private LoggerSteps $loggerStep;
    private ?string $functionClass = null;

    public function __construct()
    {
        $this->loggerStep = new LoggerSteps();
    }


    public function getMessageFromUser(): ?string
    {
        return $this->messageFromUser;
    }

    public function setMessageFromUser(?string $messageFromUser): self
    {
        $this->messageFromUser = $messageFromUser;

        return $this;
    }

    public function getSystemPrompt(): string
    {
        return $this->systemPrompt;
    }

    public function setSystemPrompt(string $systemPrompt): self
    {
        $this->systemPrompt = $systemPrompt;

        return $this;
    }


    //  ====  Logger Steps  ====

    public function getLoggerStep(): LoggerSteps
    {
        return $this->loggerStep;
    }

    public function setLoggerStep(LoggerSteps $loggerStep): self
    {
        $this->loggerStep = $loggerStep;

        return $this;
    }


    //  ====  Logger Steps  ====

    //  ====  Function Class  ====

    public function getFunctionClass(): ?string
    {
        return $this->functionClass;
    }

    public function setFunctionClass(?string $functionClass): self
    {
        $this->functionClass = $functionClass;

        return $this;
    }

    //  ====  Function Class  ====

}
