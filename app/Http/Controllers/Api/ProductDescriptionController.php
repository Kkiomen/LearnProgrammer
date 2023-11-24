<?php

namespace App\Http\Controllers\Api;

use App\Enum\DataSource;
use App\Http\Controllers\Controller;
use App\Modules\ProductDescription\ProductDescription;
use Illuminate\Http\Request;

class ProductDescriptionController extends Controller
{
    /**
     * @throws \Exception
     */
    public function prepareDescription(Request $request){
        $productDescription = new ProductDescription(DataSource::API, $request->all());
        $generatedDescription = $productDescription->getResult();
        return response()->json($generatedDescription);
    }
}
