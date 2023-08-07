<?php

namespace App\Core\Strategy;

use App\Class\Assistant\AssistantDTO;
use App\Class\Assistant\Enum\AssistantType;
use App\Class\Assistant\Repository\AssistantRepository;
use App\Core\Class\Request\Factory\RequestDTOFactory;
use App\Core\Class\Request\RequestDTO;
use App\Core\Class\Response\ResponseDTO;
use App\Core\Enum\ResponseType;
use App\Core\Helper\ResponseHelper;
use App\Core\Strategy\Message\BasicMessageStrategy;
use App\Core\Strategy\Message\ComplaintMessageStrategy;
use App\Core\Strategy\Message\MessageStrategyContext;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessageFacade
{
    private RequestDTO $requestDto;

    public function __construct(
        private readonly RequestDTOFactory $requestDTOFactory,
        private readonly MessageStrategyContext $messageStrategyContext,
        private readonly AssistantRepository $assistantRepository,
        private readonly ResponseHelper $responseHelper,
        private readonly MessageService $messageService
    ) {
    }

    public function processAndReturnResponse(): JsonResponse|StreamedResponse
    {

        $message = $this->messageService->createMessageFromRequestDto($this->requestDto);

        /**
         * @var AssistantDTO $assistant
         */
        $assistant = $this->assistantRepository->getAssistantById($this->requestDto->getAssistantId());
        if ($assistant->getType() === AssistantType::BASIC) {
            $this->messageStrategyContext->setStrategy(new BasicMessageStrategy($this->requestDto));
        } else {
            if ($assistant->getType() === AssistantType::COMPLAINT) {
                $this->messageStrategyContext->setStrategy(new ComplaintMessageStrategy($this->requestDto));
            }
        }

        $responseMessageStrategy = $this->messageStrategyContext->handle();
//        $message->setLinks($responseMessageStrategy->getLinks());

        //Update information about Prompt
        $this->messageService->updatePromptHistory($message, $responseMessageStrategy->getPrompt());
        $responseDTO = (new ResponseDTO())->setMessageDTO($message)->setResponseMessageStrategy($responseMessageStrategy);
        if ($responseMessageStrategy->getResponseType() === ResponseType::JSON) {
            return $this->responseHelper->responseJSON($responseDTO);
        }

        return $this->responseHelper->responseStream($responseDTO);
    }

    public function loadRequest(Request $request): void
    {
        $this->requestDto = $this->requestDTOFactory->createRequestDTO(
            message: $request->get('message') ?? null,
            assistant: $request->get('assistant') ?? null,
            consultant: $request->get('consultant') ?? null,
            sessionHash: $request->get('session') ?? null,
            event: $request->get('event') ?? null,
            eventDetails: $request->get('eventDetails') ?? null,
            others: $request->get('others') ?? null,
        );
    }


}
