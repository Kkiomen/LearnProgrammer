<?php

namespace App\CoreAssistant\Adapter\LLM\models\OpenAi;

enum OpenAiModel: string
{
    case DAVINCI = 'text-davinci-003';
    case GPT_3_5_TURBO = 'gpt-3.5-turbo';
    case GPT_4 = 'gpt-4';
    case TEXT_EMBEDDING_ADA  = 'text-embedding-ada-002';
}
