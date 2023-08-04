<?php

namespace App\Modules\ProductDescription\Decorators;

use Illuminate\Support\Facades\Lang;

class TargetAudiencePromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    public function getPrompt(): string
    {
        $preparedAudience = $this->prepareAudience($this->attribute);
        return !is_null($preparedAudience) ? $this->preparePromptByLangKey('prompt.target_audience', $preparedAudience) : '';
    }

    /**
     * Prepares a string representing the target audience of a product.
     * @param string $audience
     * @return string|null
     */
    private function prepareAudience(string $audience): string|null
    {
        return match ($audience) {
            'man' => Lang::get('prompt.males'),
            'woman' => Lang::get('prompt.females'),
            'children' => Lang::get('prompt.children'),
            'senior' => Lang::get('prompt.seniors'),
            default => null,
        };
    }
}
