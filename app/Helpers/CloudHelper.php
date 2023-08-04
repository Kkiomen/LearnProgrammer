<?php

namespace App\Helpers;

use App\Models\FileCloud;

class CloudHelper
{

    public static function getUuid(){
        do{
            $uuid = ApiHelper::generateRandomString(12).date('His');
        }while(FileCloud::where('uuid',$uuid)->count() > 0);
        return $uuid;
    }
}
