<?php

namespace App\Modules\ProductDescription\Decorators;

class MaterialPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.material', $this->attributesToString($this->attribute));
    }
}
