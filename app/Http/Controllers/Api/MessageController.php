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
        private readonly MessageFacade $messageFacade,
        private readonly ResponseHelper $responseHelper,
        private readonly ConversationService $conversationService,
    ) {
    }

    /**
     * Processes a new message
     * @param  Request  $request
     * @return JsonResponse|StreamedResponse
     */
    public function newMessage(Request $request): JsonResponse|StreamedResponse
    {
        $this->messageFacade->loadRequest($request);
        return $this->messageFacade->processAndReturnResponse();
    }

    /**
     * Get the messages of a conversation.
     *
     * @param Request $request The incoming HTTP request
     * @return JsonResponse The HTTP response containing the messages
     */
    public function getMessagesConversation(Request $request): JsonResponse
    {
        return $this->responseHelper->responseJSON($this->conversationService->getMessagesForView($request->get('session_hash') ?? null));
    }

    /**
     * Clear a conversation.
     *
     * @param Request $request The incoming HTTP request
     * @return JsonResponse The HTTP response indicating success or failure
     */
    public function clearConversation(Request $request){
        if($this->conversationService->clearConversation($request->get('session_hash'))){
            return $this->responseHelper->responseJSON(['status' => 'SUCCESS']);
        }
        return $this->responseHelper->responseJSON(['status' => 'FAILED']);
    }

    /**
     * Prepare a link to a specific message.
     *
     * @param Request $request The incoming HTTP request
     * @return JsonResponse The HTTP response containing the link to the message
     */
    public function prepareLinkToMessage(Request $request){
        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        $assistant = Assistant::find($request->get('assistant'));

        return $this->responseHelper->responseJSON($longTermMemoryQdrant->getMemory($request->get('message'), null, $assistant->memory_collection, true));
    }

}
