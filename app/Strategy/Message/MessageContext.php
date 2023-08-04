<?php

namespace App\Strategy\Message;

use App\Abstract\Message;
use Illuminate\Http\JsonResponse;

class MessageContext
{
    private Message $strategy;

    public function setStrategy(Message $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function handle(): array
    {
        return $this->strategy->getResult();
    }

}
