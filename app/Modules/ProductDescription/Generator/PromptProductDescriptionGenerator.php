<?php

namespace App\Modules\ProductDescription\Generator;

use App\Modules\ProductDescription\Decorators\AttributesPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\CategoryPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\DescriptionPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\DistinctiveFeaturesPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\HTMLPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\LimitPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\MaterialPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\ProductNamePromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\PromptProductDescription;
use App\Modules\ProductDescription\Decorators\SeoPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\StylePromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\SubjectPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\TargetAudiencePromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\TargetPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\UniqueFeaturesPromptProductDescriptionDecorator;
use App\Modules\ProductDescription\Decorators\WarrantyPromptProductDescriptionDecorator;

class PromptProductDescriptionGenerator
{
    /**
     * Method generates prompt for product description based on received data
     * @param array $data
     * @return string
     */
    public function generate(array $data): string
    {
        $prompt = new PromptProductDescription();

        if (isset($data['subject']) && !empty($data['subject'])) {
            $prompt = new SubjectPromptProductDescriptionDecorator($prompt, $data['subject']);
        }

        if (isset($data['productName']) && !empty($data['productName'])) {
            $prompt = new ProductNamePromptProductDescriptionDecorator($prompt, $data['productName']);
        }

        if (isset($data['category']) && !empty($data['category'])) {
            $prompt = new CategoryPromptProductDescriptionDecorator($prompt, $data['category']);
        }

        $prompt = new TargetPromptProductDescriptionDecorator($prompt);

        if (isset($data['attributes']) && !empty($data['attributes'])) {
            $prompt = new AttributesPromptProductDescriptionDecorator($prompt, $data['attributes']);
        }

        if (isset($data['targetAudience']) && !empty($data['targetAudience'])) {
            $prompt = new TargetAudiencePromptProductDescriptionDecorator($prompt, $data['targetAudience']);
        }

        if (isset($data['keywords']) && !empty($data['keywords'])) {
            $prompt = new DistinctiveFeaturesPromptProductDescriptionDecorator($prompt, $data['keywords']);
        }

        $seoKeywords = isset($data['keywordsSEO']) && !empty($data['keywordsSEO']) !== null ? $data['keywordsSEO'] : null;
        $prompt = new SeoPromptProductDescriptionDecorator($prompt, $seoKeywords);

        if (isset($data['styleAndTone']) && !empty($data['styleAndTone'])) {
            $prompt = new StylePromptProductDescriptionDecorator($prompt, $data['styleAndTone']);
        }

        if (isset($data['limitations']) && !empty($data['limitations'])) {
            $prompt = new LimitPromptProductDescriptionDecorator($prompt, $data['limitations']);
        }

        if (isset($data['material']) && !empty($data['material'])) {
            $prompt = new MaterialPromptProductDescriptionDecorator($prompt, $data['material']);
        }

        if (isset($data['warranty']) && !empty($data['warranty'])) {
            $prompt = new WarrantyPromptProductDescriptionDecorator($prompt, $data['warranty']);
        }

        if (isset($data['uniqueFeatures']) && !empty($data['uniqueFeatures'])) {
            $prompt = new UniqueFeaturesPromptProductDescriptionDecorator($prompt, $data['uniqueFeatures']);
        }

        if (isset($data['description']) && !empty($data['description'])) {
            $prompt = new DescriptionPromptProductDescriptionDecorator($prompt, $data['description']);
        }

        if (isset($data['useHtml']) && $data['useHtml'] === true) {
            $prompt = new HTMLPromptProductDescriptionDecorator($prompt);
        }

        return $prompt->getPrompt();
    }
}
