<?php

namespace App\Http\Controllers\Api;

use App\Core\Helper\ResponseHelper;
use App\Core\Strategy\MessageFacade;
use App\Services\ConversationService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessageController
{

    public function __construct(
        private MessageFacade $messageFacade,
        private readonly ResponseHelper $responseHelper,
        private readonly MessageService $messageService,
        private readonly ConversationService $conversationService,
    ) {
    }

    public function newMessage(Request $request): JsonResponse|StreamedResponse
    {
        $this->messageFacade->loadRequest($request);
        return $this->messageFacade->processAndReturnResponse();
    }

    public function getMessagesConversation(Request $request): JsonResponse
    {
        return $this->responseHelper->responseJSON($this->conversationService->getMessagesForView($request->get('session_hash')));
    }

}
