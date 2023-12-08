<?php

namespace App\CoreAssistant\Adapter\LLM;

use App\CoreAssistant\Core\Collection\Collection;

interface LanguageModel
{
    public function generate(string $prompt, string $systemPrompt, LanguageModelSettings $settings): string;
    public function generateStream(string $prompt, string $systemPrompt, LanguageModelSettings $settings): mixed;
    public function generateStreamWithConversation(string $prompt, string $systemPrompt, LanguageModelSettings $settings, Collection $collectionOfMessages): mixed;
}
