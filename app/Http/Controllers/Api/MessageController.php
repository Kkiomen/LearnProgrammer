<?php

namespace App\Http\Controllers\Api;

use App\Class\LongTermMemoryQdrant;
use App\Core\Helper\ResponseHelper;
use App\Core\Strategy\MessageFacade;
use App\Models\Assistant;
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
        return $this->responseHelper->responseJSON($this->conversationService->getMessagesForView($request->get('session_hash') ?? null));
    }

    public function clearConversation(Request $request){
        if($this->conversationService->clearConversation($request->get('session_hash'))){
            return $this->responseHelper->responseJSON(['status' => 'SUCCESS']);
        }
        return $this->responseHelper->responseJSON(['status' => 'FAILED']);
    }

    public function prepareLinkToMessage(Request $request){
        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        $assistant = Assistant::find($request->get('assistant'));

        return $this->responseHelper->responseJSON($longTermMemoryQdrant->getMemory($request->get('message'), null, $assistant->memory_collection, true));
    }

}
