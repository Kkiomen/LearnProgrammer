<?php

namespace App\Core\Class\Response;

use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\MessageDTO;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;

class ResponseDTO
{
    private ResponseMessageStrategy $responseMessageStrategy;
    private MessageInterface $messageDTO;

    public function getResponseMessageStrategy(): ResponseMessageStrategy
    {
        return $this->responseMessageStrategy;
    }

    public function setResponseMessageStrategy(ResponseMessageStrategy $responseMessageStrategy): self
    {
        $this->responseMessageStrategy = $responseMessageStrategy;
        return $this;
    }

    public function getMessageDTO(): MessageInterface
    {
        return $this->messageDTO;
    }

    public function setMessageDTO(MessageInterface $messageDTO): self
    {
        $this->messageDTO = $messageDTO;
        return $this;
    }


}
