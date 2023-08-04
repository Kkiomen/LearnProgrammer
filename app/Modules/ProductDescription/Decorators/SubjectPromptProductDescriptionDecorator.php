<?php

namespace App\Modules\ProductDescription\Decorators;

class SubjectPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.for_subject');
    }
}
