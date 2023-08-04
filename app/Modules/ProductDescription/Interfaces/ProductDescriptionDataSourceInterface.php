<?php

namespace App\Modules\ProductDescription\Interfaces;

interface ProductDescriptionDataSourceInterface
{
    public function getData(): array;
}
