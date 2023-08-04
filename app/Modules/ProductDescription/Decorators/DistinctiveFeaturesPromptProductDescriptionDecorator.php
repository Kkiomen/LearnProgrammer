<?php

namespace App\Modules\ProductDescription\Decorators;

class DistinctiveFeaturesPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.distinctive_features', $this->attributesToString($this->attribute));
    }
}
