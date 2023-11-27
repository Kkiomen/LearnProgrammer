<?php

namespace App\CoreErpAssistant\Dto\Response;



use App\CoreErpAssistant\Dto\MessageProcessor\LoggerStep\LoggerSteps;
use App\CoreErpAssistant\Enum\OpenAiModel;

class ResponseDto
{
    private string $userMessage;
    private string $systemPrompt;
    private OpenAiModel $openAiModel = OpenAiModel::CHAT_GPT_3;
    private float $temperature = 0.9;
    private ?LoggerSteps $loggerStep = null;
    private array $table = [];

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

}
