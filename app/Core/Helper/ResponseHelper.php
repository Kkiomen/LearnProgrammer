<?php

namespace App\Core\Helper;

use App\Api\OpenAiApi;
use App\Class\Message\Interface\MessageInterface;
use App\Core\Class\Response\ResponseDTO;
use App\Core\Strategy\Message\Response\ResponseMessageStrategy;
use App\Enum\OpenAiModel;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ResponseHelper
{
    public function __construct(
        private readonly OpenAiApi $openAiApi,
        private readonly MessageService $messageService
    ) {
    }

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

    public function responseStream(ResponseDTO $response): StreamedResponse
    {
        $prompt = $response->getResponseMessageStrategy()->getPrompt()->getPrompt();
        $systemPrompt = $response->getResponseMessageStrategy()->getPrompt()->getSystem();
        $messageDTO = $response->getMessageDTO();

        return response()->stream(function () use ($prompt, $systemPrompt, $messageDTO) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            $stream = $this->openAiApi->chat($prompt, OpenAiModel::CHAT_GPT_3, $systemPrompt, null, $messageDTO);
            $result = '';
            foreach ($stream as $response) {
                $message = $response->choices[0]->toArray();
                if (!empty($message['delta']['content'])) {
                    $result .= $message['delta']['content'];
                }
                $this->sendSseMessage($message, 'message');
            }
            $this->messageService->updateResultOpenAi($messageDTO, $result);
        });
    }

    /**
     * Sends a message via Server-Sent Events.
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
