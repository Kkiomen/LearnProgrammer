<?php

namespace App\CoreErpAssistant\Service\Message;

use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Exceptions\EmptyMessageUserException;
use App\CoreErpAssistant\Helper\ResponseHelper;
use App\CoreErpAssistant\Service\Event\EventExecutor;
use App\CoreErpAssistant\Service\Interfaces\MessageFacadeInterface;
use App\CoreErpAssistant\Service\MessageInterpreter\InterpretationDetails;
use App\CoreErpAssistant\Service\MessageInterpreter\MessageInterpreter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessageFacade implements MessageFacadeInterface
{
    private ?MessageProcessor $messageProcessor = null;

    public function __construct(
        private readonly MessageInterpreter $messageInterpreter,
        private readonly EventExecutor $eventExecutor,
        private readonly ResponseHelper $responseHelper
    ){}


    public function processAndReturnResponse(): JsonResponse|StreamedResponse
    {
        if($this->messageProcessor === null || empty($this->messageProcessor->getMessageFromUser())){
            throw new EmptyMessageUserException('Message from user is empty');
        }

        // Has the task of interpreting and analyzing messages from users. It decides on further actions
        /** @var InterpretationDetails $interpretationDetails */
        $interpretationDetails = $this->messageInterpreter->interpretMessage($this->messageProcessor);

        // Execute event
        $eventResult = $this->eventExecutor->executeEvent($interpretationDetails, $this->messageProcessor);

        $responseDto = $this->responseHelper->prepareResponse($this->messageProcessor, $eventResult);

        return $this->responseHelper->responseStream($responseDto);
    }

    public function loadRequest(Request $request): void
    {
        $messageProcessor = new MessageProcessor();
        $messageProcessor->setMessageFromUser($request->get('message'));

        $this->loadMessageProcessor($messageProcessor);
    }

    public function loadMessageProcessor(MessageProcessor $messageProcessor): void
    {
        $messageProcessor->getLoggerStep()->addStep([
            'message' => $messageProcessor->getMessageFromUser(),
        ], 'MessageFacade - loadMessageProcessor');

        $this->messageProcessor = $messageProcessor;
    }

    /**
     * Prepare and return the response.
     *
     * @param  MessageProcessor  $messageProcessor
     * @return JsonResponse|StreamedResponse
     */
    private function prepareResponse(MessageProcessor $messageProcessor): JsonResponse|StreamedResponse
    {
        return $this->responseHelper->re;
//
//        $responseDTO = (new ResponseDTO())
//            ->setMessageDTO($message)
//            ->setResponseMessageStrategy($responseMessageStrategy);
//
//        if ($responseMessageStrategy->getResponseType() === ResponseType::JSON) {
//            return $this->responseHelper->responseJSON($responseDTO);
//        }
//
//        return $this->responseHelper->responseStream($responseDTO);
    }
}
