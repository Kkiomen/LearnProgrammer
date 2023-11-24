<?php

namespace App\Core\Strategy\Message\Abstract;

use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\Assistant\Repository\AssistantRepository;
use App\Core\Class\Request\RequestDTO;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;

abstract class MessageStrategy
{
    protected RequestDTO $requestDTO;
    protected AssistantInterface $assistantDTO;

    public function __construct(RequestDTO $requestDTO)
    {
        $this->requestDTO = $requestDTO;
        $this->assistantDTO = $this->getAssistant();
    }

    abstract public function handle(): ResponseMessageStrategy;

    private function getAssistant(): AssistantInterface
    {
        /**
         * @var AssistantRepository $assistantRepository;
         */
        $assistantRepository = app(AssistantRepository::class);
        return $assistantRepository->getAssistantById($this->requestDTO->getAssistantId());
    }
}
