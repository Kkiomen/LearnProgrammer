<?php

namespace App\Modules\ProductDescription\Decorators;

class CategoryPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.from_category') . ',';
    }
}

