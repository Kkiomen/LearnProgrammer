<?php

namespace App\Modules\ProductDescription;

use App\Enum\DataSource;
use App\Modules\Interfaces\OpenAiModulesInterface;
use App\Modules\Modules;
use App\Modules\ProductDescription\Services\ProductDescriptionService;

class ProductDescription extends Modules implements OpenAiModulesInterface
{
    private array $data;
    private ProductDescriptionService $productDescriptionService;

    /**
     * @param DataSource $dataSource
     * @param array $data
     */
    public function __construct(DataSource $dataSource, array $data)
    {
        $this->dataSource = $dataSource;
        $this->data = $data;
        $this->productDescriptionService = app(ProductDescriptionService::class);
    }

    /**
     * Method returns the finished generated product description
     * @return array
     * @throws \Exception
     */
    public function getResult(): array
    {
        $preparedData = $this->productDescriptionService->prepareDataBySource($this->dataSource, $this->data);
        $preparedPrompt = $this->productDescriptionService->preparePrompt($preparedData);
        return [
            'result' => 'EXAMPLE',
            'data' => $preparedData,
            'prompt' => $preparedPrompt
        ];
    }

}
