<?php

namespace App\Modules\ProductDescription\Decorators;

class AttributesPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.attributes', $this->prepareAttribute());
    }

    private function prepareAttribute(){
        $result = '';
        foreach ($this->attribute as $attribute){
            $result .= $attribute['key'] . ': '. $attribute['value'] .', ';
        }
        return $result;
    }
}

