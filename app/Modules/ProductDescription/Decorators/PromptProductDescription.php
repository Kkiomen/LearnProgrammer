<?php

namespace App\Modules\ProductDescription\Decorators;

use App\Modules\ProductDescription\Interfaces\PromptProductDescriptionInterface;
use Illuminate\Support\Facades\Lang;

class PromptProductDescription implements PromptProductDescriptionInterface
{
    public function getPrompt(): string
    {
        return Lang::get('prompt.create_attractive_description');
    }
}
