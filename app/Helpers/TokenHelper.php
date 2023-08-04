<?php

namespace App\Helpers;

use App\Models\ProductDescription;
use App\Models\TokenUsage;

class TokenHelper
{
    const USD_TO_PLN = 4.50;
    const COST_USD_FOR_THOUSAND_TOKEN = 0.002;

    public static function calcEstimatedCost($token){
        $costPerTokens = ( intval($token) * self::COST_USD_FOR_THOUSAND_TOKEN ) / 1000;
        return $costPerTokens * self::USD_TO_PLN;
    }

    public static function saveInformationAboutDescription(TokenUsage $tokenUsage): void{
        if(!is_null($description)){
            $tokenUsage->product_description_id = $description->id;
            $tokenUsage->save();
        }
    }
}
