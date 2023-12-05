<?php

namespace App\CoreAssistant\Adapter\LLM\models\OpenAi;

use App\CoreAssistant\Adapter\LLM\exceptions\NotHandledLanguageModelSettingsClassException;
use App\CoreAssistant\Adapter\LLM\LanguageModel;
use App\CoreAssistant\Adapter\LLM\LanguageModelSettings;
use App\CoreAssistant\Adapter\LLM\LanguageModelType;
use OpenAI\Client;

class OpenAiLanguageModel implements LanguageModel
{
    private Client $client;

    public function __construct(){
        $this->client = \OpenAI::client(getenv('OPEN_AI_KEY'));
    }

    public function generate(string $prompt, string $systemPrompt, LanguageModelSettings $settings): string
    {
        $openAiModel = $this->getOpenAiModelBySettings($settings);

        $openAiModelParamsToGenerate = [
            'temperature' => $settings->getTemperature(),
            'model' => $openAiModel->value,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $prompt]
            ]
        ];

        $response = $this->client->chat()->create($openAiModelParamsToGenerate);
        return $response->choices[0]->message->content;
    }

    public function generateStream(string $prompt, string $systemPrompt, LanguageModelSettings $settings): mixed
    {
        $openAiModel = $this->getOpenAiModelBySettings($settings);

        $openAiModelParamsToGenerate = [
            'temperature' => $settings->getTemperature(),
            'model' => $openAiModel->value,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $prompt]
            ]
        ];

        return $this->client->chat()->createStreamed($openAiModelParamsToGenerate);
    }


    protected function getOpenAiModelBySettings(LanguageModelSettings $languageModelSettings): OpenAiModel
    {
        /** @var OpenAiModel $model */
        $model = match ($languageModelSettings->getLanguageModelType()) {
            LanguageModelType::NORMAL => OpenAiModel::GPT_3_5_TURBO,
            LanguageModelType::INTELLIGENT => OpenAiModel::GPT_4
        };

        return $model;
    }
}
