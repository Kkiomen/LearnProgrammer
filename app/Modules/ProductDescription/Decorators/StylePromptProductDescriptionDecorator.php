<?php

namespace App\Modules\ProductDescription\Decorators;
use Illuminate\Support\Facades\Lang;

class StylePromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.description_style', $this->attributesToString($this->attribute)) . Lang::get('prompt.details_style');
    }
}
