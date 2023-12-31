<?php

namespace App\Prompts;

class EventPromptHelper
{
    public static function chooseEventFromContent(string $listEvents): string
    {
        return '
            Prompt Event:
            Based on the user message, select the appropriate event.

            Schema
            (event_name) - description

            List of events:
            '. $listEvents .'


            in all other actions return event: basic

            ###
            Return only event name and nothing more
        ';
    }
}
