<?php

namespace App\Core\Strategy\Message;

use App\Core\Strategy\Message\Abstract\MessageStrategy;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;

class MessageStrategyContext
{
    private MessageStrategy $strategy;

    public function setStrategy(MessageStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function handle(): ResponseMessageStrategy
    {
        return $this->strategy->handle();
    }
}
