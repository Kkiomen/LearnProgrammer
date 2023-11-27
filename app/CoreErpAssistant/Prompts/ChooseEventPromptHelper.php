<?php

namespace App\CoreErpAssistant\Prompts;

class ChooseEventPromptHelper
{
    public static function getPrompt(string $listEvents): string
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
