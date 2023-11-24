<?php

namespace App\Core\Strategy\Message;

use App\Api\OpenAiApi;
use App\Class\LongTermMemoryQdrant;
use App\Class\PromptHistory\Prompt;
use App\Core\Enum\ResponseType;
use App\Core\Strategy\Message\abstract\MessageStrategy;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;
use App\Enum\OpenAiModel;
use App\Models\Assistant;
use App\Services\MessageService;

class BasicMessageStrategy extends MessageStrategy
{
    public function handle(): ResponseMessageStrategy
    {
        $response = new ResponseMessageStrategy();
        $response->setContent($this->requestDTO->getMessage());
        $response->setPrompt(new Prompt($this->requestDTO->getMessage(), $this->assistantDTO->getPromptHistory()->getPrompt()));
//        $this->loadLongTermMemory($response);
//        $this->loadLongTermLinks($response);

        $response->setResponseType(ResponseType::STREAM);
        return $response;
    }

    private function loadLongTermMemory(ResponseMessageStrategy &$responseMessageStrategy):void
    {
        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        $memory = $longTermMemoryQdrant->getMemory($responseMessageStrategy->getContent(), null, $this->assistantDTO->getMemoryCollection());
//        dump($responseMessageStrategy->getContent(), null, $this->assistantDTO->getMemoryCollection());
        if($memory !== null){
            $notes = implode('. ', $memory);
            $notePrompt = ' ### Note that the notes are about the user. In addition, use the following notes provided by you in your speech: ' . $notes . ' ### Note that the notes are about the user.';
            if(!empty($notes)){
                $responseMessageStrategy->getPrompt()->setSystem($responseMessageStrategy->getPrompt()->getSystem() . $notePrompt);
            }
        }
    }

    private function loadLongTermLinks(ResponseMessageStrategy &$responseMessageStrategy):void
    {
        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        $links = $longTermMemoryQdrant->getMemory($responseMessageStrategy->getContent(), null, $this->assistantDTO->getMemoryCollection(), true);
        if(!empty($links)){
            $responseMessageStrategy->setLinks($links);
        }
    }
}
