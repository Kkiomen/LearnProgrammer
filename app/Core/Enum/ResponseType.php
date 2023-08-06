<?php

namespace App\Core\Enum;

enum ResponseType: string
{
    case JSON = 'json';
    case STREAM = 'stream';
}
