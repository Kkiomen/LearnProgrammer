<?php

namespace App\Core\Event\Events;

use App\Core\Abstract\Event;
use App\Core\Dto\EventData;
use App\Core\Dto\EventResponseDto;
use Illuminate\Support\Facades\Http;

final class CalendarEvent extends Event
{
    protected ?string $name = 'calendar';
    protected ?string $description = 'adding an event to the calendar and only adds the event';
    protected array $triggers = ['kalendarz', 'kalendarza', 'kalendarzu', 'wydarzenie', 'wydarzeniu', 'calendar', 'event'];

    const WEBHOOK_SUCCESS_CODE = 200;

    /**
     * Handle the event.
     *
     * @param EventData $eventData Data related to the event
     * @return EventResponseDto Response after handling the event
     */
    public function handle(EventData $eventData): EventResponseDto
    {
        $webhookUrl = env('CALENDAR_WEBHOOK');

        // Verify that the calendar webhook is set
        if($webhookUrl === null){
            $response = new EventResponseDto($this->getName());
            $response->setContent('The calendar webhook is not set. Please contact the administrator')
                ->setChangedContent(true);
            return $response;
        }

        // Send calendar webhook
       if($this->sendWebhook($webhookUrl, $this->getPrompt(), $eventData->getContent()) === self::WEBHOOK_SUCCESS_CODE){
           $eventData->setContent('Inform you that you have successfully added events to the calendar. Add a calendar emoticon');
       }else{
           $eventData->setContent('Inform that unfortunately the event could not be added to the calendar. Inform the user to try again');
       }

       // Return response
        $response = new EventResponseDto($this->getName());
        $response->setContent($eventData->getContent())
            ->setChangedContent(true);
        return $response;
    }

    /**
     * Send a webhook request to add event in calendar
     *
     * @param string $webhook The webhook URL
     * @param string $prompt The prompt string
     * @param string $message The message sent from user
     * @return int The HTTP status code
     */
    private function sendWebhook(string $webhook, string $prompt, string $message): int
    {
        $payload = [
            'prompt' => $prompt,
            'message' => $message,
        ];

        $response = Http::post($webhook, $payload);
        return $response->status();
    }

    /**
     * Get the prompt string.
     *
     * @return string The prompt string
     */
    private function getPrompt(): string
    {
        return 'Based on the content provided by the user, prepare a JSON that is used to add a new event to the calendar. Fill in all the json elements. Return me only JSON and nothing else
                    Current date: '. now().'
                    ###
                    {
                    "name": (name),
                    "start_date": (start date),
                    "end_date": (end date),
                    "duration": (duration, Format: HH:mm)
                    }';
    }
}
