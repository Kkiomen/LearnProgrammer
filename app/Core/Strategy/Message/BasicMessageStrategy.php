<?php

namespace App\Core\Strategy\Message;

use App\Api\OpenAiApi;
use App\Class\PromptHistory\Prompt;
use App\Core\Enum\ResponseType;
use App\Core\Strategy\Message\abstract\MessageStrategy;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;
use App\Enum\OpenAiModel;

class BasicMessageStrategy extends MessageStrategy
{
    public function handle(): ResponseMessageStrategy
    {
        $response = new ResponseMessageStrategy();
        $response->setContent($this->requestDTO->getMessage());
        $response->setPrompt(new Prompt($this->requestDTO->getMessage(), null));
        $response->setResponseType(ResponseType::STREAM);
        return $response;
    }
}
