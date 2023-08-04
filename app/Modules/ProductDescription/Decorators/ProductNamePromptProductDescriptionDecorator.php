<?php

namespace App\Modules\ProductDescription\Decorators;

class ProductNamePromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.product_name');
    }
}

