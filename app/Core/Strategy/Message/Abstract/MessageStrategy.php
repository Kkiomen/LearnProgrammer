<?php

namespace App\Core\Strategy\Message\Abstract;

use App\Core\Class\Request\RequestDTO;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;

abstract class MessageStrategy
{
    protected RequestDTO $requestDTO;

    public function __construct(RequestDTO $requestDTO)
    {
        $this->requestDTO = $requestDTO;
    }

    abstract public function handle(): ResponseMessageStrategy;
}
