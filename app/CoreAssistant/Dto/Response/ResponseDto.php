<?php

namespace App\CoreAssistant\Dto\Response;

use App\CoreAssistant\Core\Collection\Collection;
use App\CoreAssistant\Domain\Message\Message;
use App\CoreAssistant\Dto\MessageProcessor\LoggerSql\LoggerSql;
use App\CoreAssistant\Dto\MessageProcessor\LoggerStep\LoggerSteps;
use App\CoreAssistant\Enum\OpenAiModel;
class ResponseDto
{
    private string $userMessage;
    private string $systemPrompt;
    private OpenAiModel $openAiModel = OpenAiModel::CHAT_GPT_3;
    private float $temperature = 0.9;
    private ?LoggerSteps $loggerStep = null;
    private ?LoggerSql $loggerSql = null;
    private array $table = [];
    private ?Message $message;
    private Collection $conversationMessages;

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }

    public function setUserMessage(string $userMessage): self
    {
        $this->userMessage = $userMessage;

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

    public function getOpenAiModel(): OpenAiModel
    {
        return $this->openAiModel;
    }

    public function setOpenAiModel(OpenAiModel $openAiModel): self
    {
        $this->openAiModel = $openAiModel;

        return $this;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getLoggerStep(): ?LoggerSteps
    {
        return $this->loggerStep;
    }

    public function setLoggerStep(?LoggerSteps $loggerStep): self
    {
        $this->loggerStep = $loggerStep;

        return $this;
    }

    public function getTable(): array
    {
        return $this->table ?? [];
    }

    public function setTable(array $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getLoggerSql(): ?LoggerSql
    {
        return $this->loggerSql;
    }

    public function setLoggerSql(?LoggerSql $loggerSql): self
    {
        $this->loggerSql = $loggerSql;

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
