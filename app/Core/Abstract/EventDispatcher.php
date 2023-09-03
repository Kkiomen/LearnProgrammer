<?php

namespace App\Core\Abstract;

use App\Api\OpenAiApi;
use App\Core\Dto\EventData;
use App\Core\Dto\EventResponseDto;
use App\Enum\OpenAiModel;
use App\Prompts\EventPromptHelper;

abstract class EventDispatcher
{
    public function flush(EventData $eventData): EventResponseDto
    {
        if(!$this->usedTriggerInContent($eventData->getContent())){
            return new EventResponseDto('basic');
        }

        $eventChoosed = $this->chooseEvent($eventData->getContent());
        foreach ($this->getListEvents() as $event){
            /**
             * @var Event $eventClass
             */
            $eventClass = app($event);
            if($eventClass instanceof Event){
                if($eventClass->getName() == $eventChoosed){
                    return $eventClass->handle($eventData);
                }
            }
        }
        return new EventResponseDto($eventChoosed);
    }

    private function chooseEvent(string $content): string
    {
        /** @var OpenAiApi $openAi */
        $openAi = app(OpenAiApi::class);
        return $openAi->completionChat($content, EventPromptHelper::chooseEventFromContent($this->getListsEventToChoose(true)));
    }

    private function usedTriggerInContent(string $content): bool
    {
        foreach ($this->getListEvents() as $event) {
            $eventClass = app($event);
            if ($eventClass instanceof Event) {
                foreach ($eventClass->getTriggers() as $trigger){
                    if(str_contains(strtolower($content), strtolower($trigger))){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function getListsEventToChoose(bool $toString = false): array|string
    {
        $resultArray = [];
        $resultString = '';
        foreach ($this->getListEvents() as $event){
            $eventClass = app($event);
            if($eventClass instanceof Event){
                $resultArray[$eventClass->getName()] = $eventClass->getDescription();
                $resultString .= $eventClass->getName() . ' - ' . $eventClass->getDescription() . '| ';
            }
        }

        if($toString){
            return $resultString;
        }
        return $resultArray;
    }

    abstract protected function getListEvents(): array;
}
