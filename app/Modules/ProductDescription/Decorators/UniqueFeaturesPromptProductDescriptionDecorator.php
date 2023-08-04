<?php

namespace App\Modules\ProductDescription\Decorators;

class UniqueFeaturesPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.uniqueFeatures', $this->attributesToString($this->attribute));
    }
}
