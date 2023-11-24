<?php

namespace App\Core\Helper;

use App\Api\OpenAiApi;
use App\Class\Assistant\Enum\AssistantType;
use App\Class\Message\Interface\MessageInterface;
use App\Core\Class\Response\ResponseDTO;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;
use App\Enum\OpenAiModel;
use App\Jobs\ComplaintGenerate;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

final readonly class ResponseHelper
{
    public function __construct(
        private OpenAiApi $openAiApi,
        private MessageService $messageService
    ) {
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
            'message' => $response->getMessageDTO()->getContent(),
            'prompt' => $response->getResponseMessageStrategy()->getPrompt()->getPrompt(),
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
        $prompt = (empty($response->getMessageDTO()->getContentFromEvent())) ? $response->getResponseMessageStrategy()->getPrompt()->getPrompt() : $response->getMessageDTO()->getContentFromEvent();;
        $systemPrompt = $response->getResponseMessageStrategy()->getPrompt()->getSystem();
        $messageDTO = $response->getMessageDTO();
        $assistantType = $response->getResponseMessageStrategy()->getType();
        $temperature = $response->getTemperature();

        return response()->stream(function () use ($prompt, $systemPrompt, $messageDTO, $assistantType, $temperature) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            $stream = $this->openAiApi->chat($prompt, OpenAiModel::GPT_4, $systemPrompt, [
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
            $this->messageService->updateResultOpenAi($messageDTO, $result);

            if($assistantType == AssistantType::COMPLAINT){
                if(str_contains($result, 'PODSUMOWANIE')){
                    ComplaintGenerate::dispatch($result);
                }
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
