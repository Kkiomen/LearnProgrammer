<?php

namespace App\Modules\ProductDescription\Decorators;

use Illuminate\Support\Facades\Lang;

class LimitPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.limitations', $this->attributesToString($this->attribute)) . parent::SPACE . Lang::get('prompt.limitations_mood_swap') . parent::DOT;
    }
}
