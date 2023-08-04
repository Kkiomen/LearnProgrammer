<?php

namespace App\Strategy\Message;

use App\Abstract\Message;
use App\Abstract\MessageData;
use App\Enum\TypeMessage;
use App\Models\Snippet;
use App\Services\CommandInvoker;
use App\Services\SnippetInvoker;
use App\Services\SnippetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class SnippetMessage extends Message
{
    protected TypeMessage $typeMessage = TypeMessage::SNIPPET;
    private SnippetInvoker $snippetInvoker;

    private SnippetService $snippetService;

    public function __construct(MessageData $messageData)
    {
        parent::__construct($messageData);
        $this->snippetInvoker = app(SnippetInvoker::class);
        $this->snippetService = app(SnippetService::class);
    }

    public function prepareData(array $payload): array
    {
        return [];
    }

    public function getResult(): array
    {
        $result = null;
        $type = 'normal';
        $fullResponse = true;
        $data = null;
        $manyResponse = false;
        $snippet = Snippet::where('mode', $this->messageData->messageModel->snippet)->first();
        $snippetPrompt = $snippet->prompt;

        if (str_contains($snippetPrompt, "{now}")) {
            $snippetPrompt = str_replace("{now}", Carbon::now()->format('l, d-m-Y H:i:s'), $snippetPrompt);
        }

        // Execute Snippets from Classes
        $resultSnippet = $this->snippetInvoker->executeSnippet($snippet->mode, $this->messageData->message);
        if(!is_null($resultSnippet)){
            $result = $resultSnippet['message'];
            $this->messageData->saveResult($result);
            $fullResponse = $resultSnippet['fullResponse'];
            $type = 'class';
            $data = $resultSnippet['data'] ?? null;
            $manyResponse = $resultSnippet['manyResponse'] ?? null;
        }

        // Execute webhooks snippet
        if(!empty($snippet->webhook)){
            $this->messageData->savePrompt($snippetPrompt);
            $webhookResponse = $this->snippetService->sendWebhook($snippet->webhook, $snippetPrompt, $this->messageData->message);
            $this->messageData->saveResult($webhookResponse);
            $result = $webhookResponse;
            $type = 'webhook';
        }

        if (str_contains($snippetPrompt, "{message}")) {
            $snippetPrompt = str_replace("{message}", $this->messageData->message, $snippetPrompt);
        }

        // Normal snippet
        if(is_null($result)){
            $result = $snippetPrompt;
            $fullResponse = false;
        }

        return [
            'message' => $result,
            'fullResponse' => $fullResponse,
            'prompt' => $snippetPrompt,
            'type' => $type,
            'data' => $data,
            'manyResponse' => $manyResponse
        ];
    }
}
