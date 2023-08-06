<?php

namespace App\Core\Strategy\Message;

use App\Core\Strategy\Message\abstract\MessageStrategy;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;

class ComplaintMessageStrategy extends MessageStrategy
{
    public function handle(): ResponseMessageStrategy
    {
        return new ResponseMessageStrategy();
    }
}
