<?php

namespace App\Http\Controllers\Api\Erp;

use App\Api\OpenAiApi;
use App\Core\Class\Request\Factory\RequestDTOFactory;
use App\Core\Helper\ResponseHelper;
use App\CoreErpAssistant\Dto\MessageProcessor\LoggerStep\LoggerSteps;
use App\CoreErpAssistant\Prompts\OrderSQLPrompt;
use App\CoreErpAssistant\Prompts\ResponseUserPrompt;
use App\CoreErpAssistant\Service\Interfaces\MessageFacadeInterface;
use App\CoreErpAssistant\Service\Message\MessageFacade;
use App\Enum\OpenAiModel;
use App\Services\ConversationService;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssistantMessageController
{
    public function __construct(
//        private readonly MessageFacade $messageFacade,
        private readonly ResponseHelper $responseHelper,
        private readonly ConversationService $conversationService,
        private MessageService $messageService,
        private readonly RequestDTOFactory $requestDTOFactory,
        private OpenAiApi $openAiApi,
        private readonly MessageFacade $messageFacade,
    ) {
    }

    public function newMessage(Request $request)
    {

        $this->messageFacade->loadRequest($request);
        return $this->messageFacade->processAndReturnResponse();

//
//        $loggerStep = new LoggerSteps();
//
//        $prompt = $request->get('message');
//        $systemPrompt = '';
//        $temperature = 0.5;
//
//        $loggerStep->addStep([
//            'description' => 'Pobranie prompta z requestu',
//            'prompt' => $prompt,
//            'systemPrompt' => $systemPrompt,
//            'temperature' => $temperature,
//        ]);
//
//        $sql = $this->openAiApi->completionChat(
//            message: $prompt,
//            systemPrompt: GetSelectPrompt::getPrompt()
//        );
//
//        $loggerStep->addStep([
//            'description' => 'Wygenerowanie sql',
//            'prompt' => $prompt,
//            'systemPrompt' => GetSelectPrompt::getPrompt(),
//            'sql' => $sql,
//        ]);
//
//        $result = DB::select(DB::raw($sql));
//        $resultJson = json_encode($result);
//
//        $loggerStep->addStep([
//            'description' => 'Pobranie danych i zamiana ich na json',
//            'resultJson' => $resultJson,
//        ]);
//
//        $systemPrompt = ResponseUserPrompt::getPrompt($prompt , $resultJson, $sql);
//
//        $loggerStep->addStep([
//            'description' => 'Przygotowanie prompt do wysłania ostatecznej odpowiedzi',
//            'systemPrompt' => $systemPrompt,
//        ]);
//
//        return response()->stream(function () use ($prompt, $systemPrompt, $temperature, $loggerStep) {
//            header('Content-Type: text/event-stream');
//            header('Cache-Control: no-cache');
//            header('Connection: keep-alive');
//
//            $stream = $this->openAiApi->chat($prompt, OpenAiModel::CHAT_GPT_3, $systemPrompt, [
//                'temperature' => $temperature
//            ]);
//            $result = '';
//            foreach ($stream as $response) {
//                $message = $response->choices[0]->toArray();
//                if (!empty($message['delta']['content'])) {
//                    $result .= $message['delta']['content'];
//                }
//                $message['steps'] = $loggerStep->getSteps();
//                $this->sendSseMessage($message, 'message');
//            }
//        });
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
