<?php

namespace App\Http\Controllers\Api\Erp;

use App\Api\OpenAiApi;
use App\Class\Assistant\Enum\AssistantType;
use App\Core\Class\Request\Factory\RequestDTOFactory;
use App\Core\Helper\ResponseHelper;
use App\Enum\OpenAiModel;
use App\Jobs\ComplaintGenerate;
use App\Services\ConversationService;
use App\Services\MessageService;
use Illuminate\Http\Request;

class AssistantMessageController
{
    public function __construct(
//        private readonly MessageFacade $messageFacade,
        private readonly ResponseHelper $responseHelper,
        private readonly ConversationService $conversationService,
        private MessageService $messageService,
        private readonly RequestDTOFactory $requestDTOFactory,
        private OpenAiApi $openAiApi,
    ) {
    }

    public function newMessage(Request $request)
    {
//        return response()->json([
//            'message' => 'Hello World!'
//        ]);

        $prompt = $request->get('message');
        $systemPrompt = '';
        $messageDTO = null;
        $assistantType = null;
        $temperature = 0.5;

        return response()->stream(function () use ($prompt, $systemPrompt, $messageDTO, $assistantType, $temperature) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            $stream = $this->openAiApi->chat($prompt, OpenAiModel::CHAT_GPT_3, $systemPrompt, [
                'temperature' => $temperature
            ], $messageDTO);
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
}
