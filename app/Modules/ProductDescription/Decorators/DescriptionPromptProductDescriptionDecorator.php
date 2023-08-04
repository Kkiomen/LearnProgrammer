<?php

namespace App\Modules\ProductDescription\Decorators;

class DescriptionPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.description');
    }
}
