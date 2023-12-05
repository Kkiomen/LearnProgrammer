<?php

namespace App\CoreAssistant\Abstract;

abstract class Prompt
{
    const PROMPT = 'Say hey';

    protected array $options = [];

    public static function getPrompt(): string
    {
        return static::getPrompt();
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
