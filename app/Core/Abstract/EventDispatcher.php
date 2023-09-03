<?php

namespace App\Core\Abstract;

use App\Api\OpenAiApi;
use App\Core\Dto\EventData;
use App\Core\Dto\EventResponseDto;
use App\Enum\OpenAiModel;
use App\Prompts\EventPromptHelper;

abstract class EventDispatcher
{
    /**
     * Find and execute the event.
     *
     * @param EventData $eventData Data related to the event
     * @return EventResponseDto Response after flushing the event
     */
    public function execute(EventData $eventData): EventResponseDto
    {
        if(!$this->usedTriggerInContent($eventData->getContent())){
            return new EventResponseDto('basic');
        }

        $eventChosen = $this->chooseEvent($eventData->getContent());
        foreach ($this->getListEvents() as $event){
            /**
             * @var Event $eventClass
             */
            $eventClass = app($event);
            if($eventClass instanceof Event){
                if($eventClass->getName() == $eventChosen){
                    return $eventClass->handle($eventData);
                }
            }
        }
        return new EventResponseDto($eventChosen);
    }

    /**
     * Choose an event based on the content.
     *
     * @param string $content The content string
     * @return string The name of the chosen event
     */
    private function chooseEvent(string $content): string
    {
        /** @var OpenAiApi $openAi */
        $openAi = app(OpenAiApi::class);
        return $openAi->completionChat($content, EventPromptHelper::chooseEventFromContent($this->getListsEventToChoose(true)));
    }

    /**
     * Check if any triggers are used in the content.
     *
     * @param string $content The content string
     * @return bool True if any triggers are used, otherwise false
     */
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

    /**
     * Get a list of events to choose from.
     *
     * @param bool $toString If true, return as a string, otherwise as an array
     * @return array|string A list of events or a string representation
     */
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

    /**
     * Abstract method to get the list of events.
     *
     * @return array An array of event names
     */
    abstract protected function getListEvents(): array;
}
