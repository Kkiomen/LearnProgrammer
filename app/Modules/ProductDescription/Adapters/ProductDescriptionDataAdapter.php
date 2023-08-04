<?php

namespace App\Modules\ProductDescription\Adapters;

use App\Enum\DataSource;
use App\Modules\ProductDescription\DataSource\ApiProductDescriptionDataSource;
use App\Modules\ProductDescription\DataSource\ProductDescriptionDataSource;

class ProductDescriptionDataAdapter
{
    private DataSource $dataSource;
    private array $data;

    /**
     * @param DataSource $dataSource
     * @param array $data
     */
    public function __construct(DataSource $dataSource, array $data)
    {
        $this->dataSource = $dataSource;
        $this->data = $data;
    }

    /**
     * Method returns universal data ready to support prompt preparation for open ai api
     * @return array|null
     * @throws \Exception
     */
    public function getData(): ?array{
        $dataManager = $this->getProductDescriptionDataSourceManager();
        if(is_null($dataManager)){
            return throw new \Exception('An unsupported data source was used');
        }

        return $dataManager->getData();
    }

    /**
     * Method returns a class that will return universal data based on where the data to generate the prompt came from
     * @return ApiProductDescriptionDataSource|null
     */
    private function getProductDescriptionDataSourceManager(): ?ApiProductDescriptionDataSource
    {
        return match ($this->dataSource) {
            DataSource::API => new ApiProductDescriptionDataSource($this->data),
            default => null,
        };
    }

}
