<?php

namespace App\Modules\ProductDescription\Decorators;

use Illuminate\Support\Facades\Lang;

class SeoPromptProductDescriptionDecorator extends PromptProductDescriptionDecorator
{
    private $seoList = 'XYZ';

    public function getPrompt(): string
    {
        return $this->preparePromptByLangKey('prompt.seo_keyword', $this->seoList) . parent::DOT . parent::SPACE . Lang::get('prompt.seo_description') . parent::DOT;
    }

}
