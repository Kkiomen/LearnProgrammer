<?php

namespace App\CoreAssistant\Service\MessageInterpreter;

use App\CoreAssistant\Abstract\Event;
use App\CoreAssistant\Api\OpenAiApi;
use App\CoreAssistant\DeclarationClass\EventsList;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Enum\OpenAiModel;
use App\CoreAssistant\Prompts\ChooseEventPromptHelper;
use App\CoreAssistant\Service\Interfaces\MessageInterpreterInterface;

/**
 * Has the task of interpreting and analyzing messages from users. It decides on further actions
 */
class MessageInterpreter implements MessageInterpreterInterface
{
    private array $eventListClasses = [];

    public function __construct(
        private readonly EventsList $eventsList,
        private readonly OpenAiApi $openAiApi,
    ){
        $this->eventListClasses = $this->prepareEventsList();
    }

    /**
     * Has the task of interpreting and analyzing messages from users. It decides on further actions
     * @param  MessageProcessor  $messageProcessor
     * @return InterpretationDetails
     */
    public function interpretMessage(MessageProcessor $messageProcessor): InterpretationDetails
    {
        $result = new InterpretationDetails();

        // Check if any triggers are used in the content.
        // Triggers allow for better control over the handling of the process that will be followed to display the final message to the end user
        if(!$this->usedTriggerInContent($messageProcessor->getMessageFromUser())){
            $messageProcessor->getLoggerStep()->addStep([
                'type' => $result->getType(),
                'message' => 'No event has triggers to handle this message',
            ], 'MessageInterpreter');

            return $result;
        }

        // Choose an event based on the content - by LLM
        $eventChosen = $this->chooseEvent($messageProcessor->getMessageFromUser());

        foreach ($this->eventListClasses as $eventClass){
            // Check if the event is in the list of events
            if($eventClass->getName() == $eventChosen){
                $result
                    ->setType($eventChosen)
                    ->setInterpretedClass($eventClass);


                $messageProcessor->getLoggerStep()->addStep([
                    'type' => $result->getType(),
                    'message' => 'Event chosen',
                    'eventChosen' => $eventChosen,
                    'interpretedClass' => $eventClass::class
                ], 'MessageInterpreter');

                return $result;
            }
        }

        // If the event is not in the list of events, return the default event
        $messageProcessor->getLoggerStep()->addStep([
            'type' => $result->getType(),
            'message' => 'Not found event',
            'eventChosen' => $eventChosen
        ], 'MessageInterpreter');

        return $result;
    }

    /**
     * Choose an event based on the content.
     *
     * @param string $content The content string
     * @return string The name of the chosen event
     */
    private function chooseEvent(string $content): string
    {
        return $this->openAiApi->completionChat($content, ChooseEventPromptHelper::getPrompt($this->getListsEventToChoose(true)), OpenAiModel::GPT_4
        );
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
        foreach ($this->eventListClasses as $eventClass){
            $resultArray[$eventClass->getName()] = $eventClass->getDescription();
            $resultString .= $eventClass->getName() . ' - ' . $eventClass->getDescription() . '| ';
        }

        if($toString){
            return $resultString;
        }

        return $resultArray;
    }

    /**
     * Check if any triggers are used in the content.
     *
     * @param string $content The content string
     * @return bool True if any triggers are used, otherwise false
     */
    private function usedTriggerInContent(string $content): bool
    {
        foreach ($this->eventListClasses as $eventClass) {
            foreach ($eventClass->getTriggers() as $trigger){
                if(str_contains(strtolower($content), strtolower($trigger))){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Prepare events list
     */
    private function prepareEventsList(): array
    {
        $events = [];

        foreach ($this->eventsList->getList() as $event) {
            $eventClass = app($event);
            if ($eventClass instanceof Event) {
                $events[] = $eventClass;
            }
        }

        return $events;
    }
}
