<?php

namespace App\Http\Controllers\Api;

use App\Api\OpenAiApi;
use App\Class\Assistant\Enum\AssistantType;
use App\Class\LongTermMemoryQdrant;
use App\Class\Message\Interface\MessageInterface;
use App\Class\PromptHistory\Prompt;
use App\Core\Class\Request\Factory\RequestDTOFactory;
use App\Core\Class\Request\RequestDTO;
use App\Core\Class\Response\ResponseDTO;
use App\Core\Helper\ResponseHelper;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;
use App\Core\Strategy\MessageFacade;
//use App\Models\Assistant;
use App\Enum\OpenAiModel;
use App\Jobs\ComplaintGenerate;
use App\Prompts\EventPromptHelper;
use App\Services\ConversationService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessageController
{
    private RequestDTO $requestDto;
    public function __construct(
//        private readonly MessageFacade $messageFacade,
        private readonly ResponseHelper $responseHelper,
        private readonly ConversationService $conversationService,
        private MessageService $messageService,
        private readonly RequestDTOFactory $requestDTOFactory,
        private OpenAiApi $openAiApi,
    ) {
    }

    /**
     * Processes a new message
     * @param  Request  $request
     * @return JsonResponse|StreamedResponse
     */
    public function newMessage(Request $request): JsonResponse|StreamedResponse
    {
        $this->loadRequest($request);
        $messageDTO = $this->createMessage();
        $response = new ResponseMessageStrategy();
        $response->setContent($request->get('message'));
        $response->setPrompt(new Prompt($request->get('message'), $request->get('system')));
        $response->setType(AssistantType::BASIC);


        $responseDTO = (new ResponseDTO())
            ->setMessageDTO($messageDTO)
            ->setResponseMessageStrategy($response)
            ->setTemperature($request->get('temperature'));

        return $this->responseHelper->responseStream($responseDTO);
    }

    public function newMessagePlayground(Request $request): StreamedResponse
    {

        $prompt = $request->get('message');
        $systemPrompt = $request->get('system');
        $temperature = $request->get('temperature');

        return response()->stream(function () use ($prompt, $systemPrompt, $temperature) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            $stream = $this->openAiApi->chat($prompt, OpenAiModel::GPT_4, $systemPrompt, [
                'temperature' => $temperature
            ]);
            $result = '';
            foreach ($stream as $response) {
                $message = $response->choices[0]->toArray();
                if (!empty($message['delta']['content'])) {
                    $result .= $message['delta']['content'];
                }
                $this->sendSseMessage($message, 'message');
            }
//            $this->messageService->updateResultOpenAi($messageDTO, $result);

//            if($assistantType == AssistantType::COMPLAINT){
//                if(str_contains($result, 'PODSUMOWANIE')){
//                    ComplaintGenerate::dispatch($result);
//                }
//            }
        });
    }

    private function createMessage(): MessageInterface
    {
        return $this->messageService->createMessageFromRequestDto($this->requestDto);
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
     * Sends a message via Server-Sent Events (SSE).
     * @param $data
     * @param $event
     * @return void
     */
    private function sendSseMessage($data, $event = null): void
    {
        if ($event) {
            echo "event: {$event}\n";
        }
        echo "data: ".json_encode($data)."\n\n";
        ob_flush();
        flush();
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
//    /**
//     * Get the messages of a conversation.
//     *
//     * @param Request $request The incoming HTTP request
//     * @return JsonResponse The HTTP response containing the messages
//     */
//    public function getMessagesConversation(Request $request): JsonResponse
//    {
//        return $this->responseHelper->responseJSON($this->conversationService->getMessagesForView($request->get('session_hash') ?? null));
//    }
//
//    /**
//     * Clear a conversation.
//     *
//     * @param Request $request The incoming HTTP request
//     * @return JsonResponse The HTTP response indicating success or failure
//     */
//    public function clearConversation(Request $request){
//        if($this->conversationService->clearConversation($request->get('session_hash'))){
//            return $this->responseHelper->responseJSON(['status' => 'SUCCESS']);
//        }
//        return $this->responseHelper->responseJSON(['status' => 'FAILED']);
//    }
//
//    /**
//     * Prepare a link to a specific message.
//     *
//     * @param Request $request The incoming HTTP request
//     * @return JsonResponse The HTTP response containing the link to the message
//     */
//    public function prepareLinkToMessage(Request $request){
//        /**
//         * @var LongTermMemoryQdrant $longTermMemoryQdrant
//         */
//        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
//        $assistant = Assistant::find($request->get('assistant'));
//
//        return $this->responseHelper->responseJSON($longTermMemoryQdrant->getMemory($request->get('message'), null, $assistant->memory_collection, true));
//    }


}
