<?php

namespace App\Modules\ProductDescription\Decorators;

class TargetPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.target_description');
    }
}

