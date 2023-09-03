<?php

namespace App\Core\Strategy;

use App\Class\Assistant\AssistantDTO;
use App\Class\Assistant\Enum\AssistantType;
use App\Class\Assistant\Repository\AssistantRepository;
use App\Class\Message\Interface\MessageInterface;
use App\Core\Class\Request\Factory\RequestDTOFactory;
use App\Core\Class\Request\RequestDTO;
use App\Core\Class\Response\ResponseDTO;
use App\Core\Dto\EventData;
use App\Core\Enum\ResponseType;
use App\Core\Event\EventHandler;
use App\Core\Helper\ResponseHelper;
use App\Core\Strategy\Message\BasicMessageStrategy;
use App\Core\Strategy\Message\ComplaintMessageStrategy;
use App\Core\Strategy\Message\MessageStrategyContext;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;
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
        private readonly MessageService $messageService,
        private readonly EventHandler $eventHandler,
    ) {
    }

    /**
     * Processes a request to handle a new message and returns a respon
     *
     * @return JsonResponse|StreamedResponse
     */
    public function processAndReturnResponse(): JsonResponse|StreamedResponse
    {
        $assistant = $this->fetchAssistant();
        $message = $this->createMessage();

        $this->handleEventAndUpdateMessage($message);
        $this->setMessageStrategy($assistant);

        $responseMessageStrategy = $this->messageStrategyContext->handle();
        $responseMessageStrategy->setType($assistant->getType());

        $this->updateMessageAndHistory($message, $responseMessageStrategy);

        return $this->prepareResponse($responseMessageStrategy, $message);
    }


    /**
     * Fetch assistant data.
     *
     * @return AssistantDTO
     */
    private function fetchAssistant(): AssistantDTO
    {
        return $this->assistantRepository->getAssistantById($this->requestDto->getAssistantId());
    }

    /**
     * Create message from RequestDTO.
     *
     * @return MessageInterface
     */
    private function createMessage(): MessageInterface
    {
        return $this->messageService->createMessageFromRequestDto($this->requestDto);
    }

    /**
     * Handle event and update message content if necessary.
     *
     * @param MessageInterface $message
     */
    private function handleEventAndUpdateMessage(MessageInterface $message): void
    {
        $event = $this->eventHandler->execute((new EventData())
            ->setContent($message->getContent())
            ->setAssistantId($this->requestDto->getAssistantId()));

        if ($event->isChangedContent()) {
            $message->setContentFromEvent($event->getContent());
        }
    }

    /**
     * Sets the appropriate message handling strategy based on the type of assistant.
     *
     * @param AssistantDTO $assistant
     */
    private function setMessageStrategy(AssistantDTO $assistant): void
    {
        $strategy = match ($assistant->getType()) {
            AssistantType::BASIC => new BasicMessageStrategy($this->requestDto),
            AssistantType::COMPLAINT => new ComplaintMessageStrategy($this->requestDto),
            default => throw new \InvalidArgumentException("Invalid assistant type"),
        };

        $this->messageStrategyContext->setStrategy($strategy);
    }

    /**
     * Update the message and prompt history.
     *
     * @param MessageInterface $message
     * @param ResponseMessageStrategy $responseMessageStrategy
     */
    private function updateMessageAndHistory(MessageInterface $message, ResponseMessageStrategy $responseMessageStrategy): void
    {
        $message->setLinks(implode(';', $responseMessageStrategy->getLinks() ?? []));
        $this->messageService->updatePromptHistory($message, $responseMessageStrategy->getPrompt());
    }

    /**
     * Prepare and return the response.
     *
     * @param ResponseMessageStrategy $responseMessageStrategy
     * @param MessageInterface $message
     * @return JsonResponse|StreamedResponse
     */
    private function prepareResponse(ResponseMessageStrategy $responseMessageStrategy, MessageInterface $message): JsonResponse|StreamedResponse
    {
        $responseDTO = (new ResponseDTO())
            ->setMessageDTO($message)
            ->setResponseMessageStrategy($responseMessageStrategy);

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
