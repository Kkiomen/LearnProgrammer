<?php

namespace App\CoreAssistant\Dto\MessageProcessor;

use App\CoreAssistant\Core\Collection\Collection;
use App\CoreAssistant\Domain\Message\Message;
use App\CoreAssistant\Dto\MessageProcessor\LoggerStep\LoggerSteps;

class MessageProcessor
{
    private ?string $messageFromUser = null;
    private string $systemPrompt;
    private LoggerSteps $loggerStep;
    private ?string $functionClass = null;

    private ?string $sessionHash = null;

    private Message $message;

    private Collection $conversationMessages;

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


    public function getSessionHash(): ?string
    {
        return $this->sessionHash;
    }

    public function setSessionHash(?string $sessionHash): void
    {
        $this->sessionHash = $sessionHash;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getConversationMessages(): Collection
    {
        return $this->conversationMessages;
    }

    public function setConversationMessages(Collection $conversationMessages): self
    {
        $this->conversationMessages = $conversationMessages;

        return $this;
    }
}
