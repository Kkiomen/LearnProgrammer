<?php

namespace App\CoreAssistant\Helper;


use App\CoreAssistant\Adapter\Entity\Message\MessageRepository;
use App\CoreAssistant\Adapter\LLM\LanguageModel;
use App\CoreAssistant\Adapter\LLM\LanguageModelSettings;
use App\CoreAssistant\Adapter\LLM\LanguageModelType;
use App\CoreAssistant\Api\OpenAiApi;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Dto\Response\ResponseDto;
use App\CoreAssistant\Enum\OpenAiModel;
use App\CoreAssistant\Service\Event\EventResult;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ResponseHelper
{
    public function __construct(
        private OpenAiApi $openAiApi,
        private MessageRepository $messageRepository,
        private LanguageModel $languageModel
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
        $response->setMessage($messageProcessor->getMessage());
        $response->setLoggerStep($messageProcessor->getLoggerStep());
        $response->setLoggerSql($messageProcessor->getLoggerSql());
        $response->setTable($eventResult->getResultResponseTable());
        $response->setConversationMessages($messageProcessor->getConversationMessages());

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
        $loggerSql = $response->getLoggerSql();
        $table = $response->getTable();
        $messageModel = $response->getMessage();
        $conversation = $response->getConversationMessages();

        return response()->stream(function () use ($prompt, $systemPrompt, $temperature, $loggerStep, $loggerSql, $table, $messageModel, $conversation) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            $stream = $this->languageModel->generateStreamWithConversation(
                prompt: $prompt,
                systemPrompt: $systemPrompt,
                settings: (new LanguageModelSettings())->setLanguageModelType(LanguageModelType::NORMAL)->setTemperature(0.7),
                collectionOfMessages: $conversation
            );

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

            if($messageModel !== null){
                $messageModel->setResult($result);
                $messageModel->setPrompt($prompt);
                $messageModel->setSteps(json_encode($loggerStep->getSteps()));
                $messageModel->setQueries(json_encode($loggerSql->getQueriesSql()));
                $messageModel->setSystem($systemPrompt);

                $this->messageRepository->save($messageModel);
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
