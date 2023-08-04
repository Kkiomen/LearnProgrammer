<?php

namespace App\Modules\ProductDescription\Services;

use App\Enum\DataSource;
use App\Modules\ProductDescription\Adapters\ProductDescriptionDataAdapter;
use App\Modules\ProductDescription\Generator\PromptProductDescriptionGenerator;

class ProductDescriptionService
{

    private PromptProductDescriptionGenerator $productDescriptionGenerator;

    /**
     * @param PromptProductDescriptionGenerator $productDescriptionGenerator
     */
    public function __construct(PromptProductDescriptionGenerator $productDescriptionGenerator)
    {
        $this->productDescriptionGenerator = $productDescriptionGenerator;
    }

    /**
     * Method prepares universal data to generate a prompt based on the source where the data came from
     * @param DataSource $dataSource
     * @param array $data
     * @return array|null
     * @throws \Exception
     */
    public function prepareDataBySource(DataSource $dataSource, array $data){
        $productDescriptionDataAdapter = new ProductDescriptionDataAdapter($dataSource, $data);
        return $productDescriptionDataAdapter->getData();
    }

    /**
     * The method prepares a prompt for the product description based on the received data
     * @param array $data
     * @return string
     */
    public function preparePrompt(array $data): string{
        return $this->productDescriptionGenerator->generate($data);
    }

}
