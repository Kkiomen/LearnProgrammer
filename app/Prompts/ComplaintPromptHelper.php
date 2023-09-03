<?php
namespace App\Prompts;

class ComplaintPromptHelper
{
    public static function generateResultJSON(): string
    {
        return 'Create a JSON based on the claim summary. Return the JSON and only the JSON.
                Format:
                {
                "subject_complaint":  (product complaint),
                "description_complaint": (description complaint),
                "time_complaint: (complaint processing time),
                "result_complaint": (refund, repair, replacement with a new one)
                }';
    }
}
