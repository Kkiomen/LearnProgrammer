<?php

namespace App\CoreErpAssistant\Helper;


use App\CoreErpAssistant\Api\OpenAiApi;
use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Dto\Response\ResponseDto;
use App\CoreErpAssistant\Enum\OpenAiModel;
use App\CoreErpAssistant\Service\Event\EventResult;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ResponseHelper
{
    public function __construct(
        private OpenAiApi $openAiApi
    ) {
    }

    public function prepareResponse(MessageProcessor $messageProcessor, EventResult $eventResult): ResponseDto
    {
        $userMessage = $eventResult->getResultResponseUserMessage() ?? $messageProcessor->getMessageFromUser() ?? '';
        $systemPrompt = $eventResult->getResultResponseSystemPrompt() ?? '';
        $temperature = $eventResult->getResultResponseTemperature() ?? 0.6;

        $messageProcessor->getLoggerStep()->addStep([
            'userMessage' => $userMessage,
            'systemPrompt' => $systemPrompt,
            'temperature' => $temperature,
        ], 'ResponseHelper - przygotowanie odpowiedzi końcowej');


        $response = new ResponseDto();
        $response->setUserMessage($userMessage);
        $response->setSystemPrompt($systemPrompt);
        $response->setTemperature($temperature);
        $response->setLoggerStep($messageProcessor->getLoggerStep());
        $response->setTable($eventResult->getResultResponseTable());
        return $response;
    }

    /**
     * Generates a JSON response.
     *
     * @param ResponseDTO|array $response
     * @return JsonResponse
     */
    public function responseJSON(ResponseDTO|array $response): JsonResponse
    {
        if (is_array($response)) {
            return response()->json($response);
        }

        return response()->json([
            'message' => $response->getUserMessage(),
            'prompt' => $response->getSystemPrompt(),
        ]);
    }

    /**
     * Generates a streamed response.
     *
     * @param ResponseDTO $response
     * @return StreamedResponse
     */
    public function responseStream(ResponseDTO $response): StreamedResponse
    {
        $prompt = $response->getUserMessage();
        $systemPrompt = $response->getSystemPrompt();
        $temperature = $response->getTemperature();
        $loggerStep = $response->getLoggerStep();
        $table = $response->getTable();

        return response()->stream(function () use ($prompt, $systemPrompt, $temperature, $loggerStep, $table) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            $stream = $this->openAiApi->chat($prompt, OpenAiModel::CHAT_GPT_3, $systemPrompt, [
                'temperature' => $temperature
            ]);
            $result = '';
            foreach ($stream as $response) {
                $message = $response->choices[0]->toArray();
                if (!empty($message['delta']['content'])) {
                    $result .= $message['delta']['content'];
                }

                if($loggerStep !== null){
                    $message['steps'] = $loggerStep->getSteps();
                }

                $message['table'] = $table;

                $this->sendSseMessage($message, 'message');
            }
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
