<?php

namespace App\Modules\ProductDescription\DataSource;

use App\Modules\ProductDescription\Interfaces\ProductDescriptionDataSourceInterface;

abstract class ProductDescriptionDataSource implements ProductDescriptionDataSourceInterface
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
