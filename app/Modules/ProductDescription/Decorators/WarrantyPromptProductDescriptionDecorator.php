<?php

namespace App\Modules\ProductDescription\Decorators;

class WarrantyPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.warranty');
    }
}
