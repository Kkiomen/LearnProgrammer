<?php

namespace App\Modules\ProductDescription\Decorators;

class HTMLPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.html');
    }
}
