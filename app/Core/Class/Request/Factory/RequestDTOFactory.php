<?php

namespace App\Core\Class\Request\Factory;

use App\Core\Class\Event\Event;
use App\Core\Class\Request\RequestDTO;

class RequestDTOFactory
{
    public function createRequestDTO(
        ?string $message = null,
        ?string $assistant = null,
        ?string $consultant = null,
        ?string $sessionHash = null,
        ?string $event = null,
        ?string $eventDetails = null,
        ?array $others = null
    ): RequestDTO
    {
        $requestDto = new RequestDTO();
        $requestDto->setMessage($message)
        ->setAssistantId($assistant)
        ->setConsultantId($consultant)
        ->setSessionHash($sessionHash)
        ->setEvent(new Event())
        ->setOthers($others);

        //TODO: Add event and details (pattern strategy)

        return $requestDto;
    }

}
