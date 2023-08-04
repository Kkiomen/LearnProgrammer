<?php

namespace App\Services;

use App\Class\OpenAiMessage;
use App\Enum\SnippetType;
use App\Models\GroupUser;
use App\Models\Message;
use App\Models\Snippet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SnippetService
{
    private SnippetInvoker $snippetInvoker;

    /**
     * @param SnippetInvoker $snippetInvoker
     */
    public function __construct(SnippetInvoker $snippetInvoker)
    {
        $this->snippetInvoker = $snippetInvoker;
    }


    public function saveSnippet(?int $id, string $name, ?string $prompt, SnippetType $snippetType, string $webhook = null): array
    {
        if (empty($webhook)) {
            $webhook = null;
        }
        if (!is_null($id)) {
            $snippet = Snippet::where('id', $id)->first();
            if (Snippet::hasPermissionToModify($snippet)) {
                $snippet->update([
                    'name' => $name,
                    'prompt' => $prompt,
                    'mode' => Snippet::processName($name),
                    'type' => $snippetType->value,
                    'webhook' => $webhook
                ]);
                return [
                    'status' => 'success',
                    'message' => 'Snippet was modified correctly',
                    'mode' => 'modification'
                ];
            }

            return [
                'status' => 'danger',
                'message' => 'You dont have permission',
                'mode' => 'modification'
            ];
        }

        Snippet::create([
            'name' => $name,
            'user_id' => Auth::user()->id,
            'prompt' => $prompt,
            'mode' => Snippet::processName($name),
            'type' => $snippetType->value,
            'webhook' => $webhook
        ]);

        return [
            'status' => 'success',
            'message' => 'Snippet was added correctly',
            'mode' => 'add'
        ];
    }

    /**
     * Returns a message based on the activated snippet
     *
     * If there is no {message} in the content, I put the template to the system
     * Returned value "full" means whether it needs to be posted for analysis by chatgpt or displayed right away
     * @param Request $request
     * @return array
     */
    public function getResultSnippet(Request $request, ?Message $messageModel)
    {
        if(!is_null($messageModel)){
            $snippet = Snippet::where('id', $messageModel->snippet)->first();
            $userMessage = $messageModel->prompt;
            $system = $messageModel->system;
            $snippetPrompt = $system;
        }else{
            $message = $request->get('message');
            $mode = $request->get('mode');
            $snippet = Snippet::where('mode', $mode)->first();
            $snippetPrompt = $snippet->prompt;
            $system = null;


            if (str_contains($snippetPrompt, "{now}")) {
                $snippetPrompt = str_replace("{now}", Carbon::now()->format('l, d-m-Y H:i:s'), $snippetPrompt);
            }

            if (strpos($snippetPrompt, "{message}") !== false) {
                $userMessage = str_replace("{message}", $message, $snippetPrompt);
            } else {
                $userMessage = $message;
                $system = $snippetPrompt;
            }
        }

        // Execute Snippets from Classes
        $resultSnippet = $this->snippetInvoker->executeSnippet($snippet->mode, $userMessage);
        if(!is_null($resultSnippet)){
            return $this->getResult($userMessage, true, $resultSnippet, $system);
        }

        // Execute webhooks snippet
        if(!empty($snippet->webhook)){
            $webhookResponse = $this->sendWebhook($snippet->webhook, $snippetPrompt, $userMessage);
            return $this->getResult($userMessage, true, $webhookResponse, $system);
        }

        if(!is_null($messageModel)){
            OpenAiMessage::updateSnippet($snippet->id, $messageModel->id ?? null);
        }
        return $this->getResult($userMessage, false, null, $system);
    }

    private function getSnippet(Request $request, ?Message $messageModel): Snippet
    {
        if (!is_null($messageModel)) {
            return Snippet::findOrFail($messageModel->snippet);
        }

        $mode = $request->get('mode');
        return Snippet::where('mode', $mode)->firstOrFail();
    }

    private function getPrompt(string $message, string $prompt): string
    {
        if (strpos($prompt, "{message}") !== false) {
            $prompt = str_replace("{message}", $message, $prompt);
        }

        if (str_contains($prompt, "{now}")) {
            $prompt = str_replace("{now}", now(), $prompt);
        }

        return $prompt;
    }

    private function updateSnippet(int $snippetId, ?int $messageId): void
    {
        if (!is_null($messageId)) {
            OpenAiMessage::updateSnippet($snippetId, $messageId);
        }
    }

    public function sendWebhook(string $webhook, string $prompt, string $message): string
    {
        $payload = [
            'prompt' => $prompt,
            'message' => $message,
        ];

        $response = Http::post($webhook, $payload);
        return $response->body();
    }

    private function getResult(string $preparedPrompt, string $full, string $message = null, string $system = null): array
    {
        return [
            'prompt' => $preparedPrompt,
            'full' => $full,
            'message' => $message,
            'system' => $system,
        ];
    }


    public function getSnippetToModify(): array
    {
        $currentUserId = (int) Auth::user()->id;
        $privateSnippets = Snippet::where('type', 'private')->where('user_id', $currentUserId)->get();

        $groupUserIds = GroupUser::where('user_id', $currentUserId)->pluck('group_id')->toArray();
        $groupSnippets = Snippet::whereIn('user_id', $groupUserIds)
            ->where('type', SnippetType::GROUP)
            ->get();

        $snippets = $privateSnippets->merge($groupSnippets);

        $filteredData = $snippets->map(function (Snippet $snippet) {
            return [
                'id' => $snippet->id,
                'mode' => $snippet->mode,
                'text' => $snippet->name,
            ];
        });

        return $filteredData->toArray();
    }


}
