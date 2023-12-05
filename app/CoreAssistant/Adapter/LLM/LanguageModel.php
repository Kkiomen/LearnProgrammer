<?php

namespace App\CoreAssistant\Adapter\LLM;

interface LanguageModel
{
    public function generate(string $prompt, string $systemPrompt, LanguageModelSettings $settings): string;
    public function generateStream(string $prompt, string $systemPrompt, LanguageModelSettings $settings): mixed;
}
