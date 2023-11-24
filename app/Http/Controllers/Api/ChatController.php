<?php

namespace App\Http\Controllers\Api;

use App\Abstract\MessageData;
use App\Api\OpenAiApi;
use App\Class\LongTermMemory;
use App\Enum\OpenAiModel;
use App\Enum\TypeMessage;
use App\Helpers\ApiHelper;
use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\ChatService;
use App\Services\CommandInvoker;
use App\Strategy\Message\CommandMessage;
use App\Strategy\Message\MessageContext;
use App\Strategy\Message\SnippetMessage;
use App\Strategy\Message\OpenAiMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    private ChatService $chatService;
    private CommandInvoker $commandInvoker;
    private OpenAiApi $openAiApi;
    private LongTermMemory $longTermMemory;

    /**
     * @param ChatService $chatService
     */
    public function __construct(ChatService $chatService, CommandInvoker $commandInvoker, OpenAiApi $openAiApi,  LongTermMemory $longTermMemory)
    {
        $this->chatService = $chatService;
        $this->commandInvoker = $commandInvoker;
        $this->openAiApi = $openAiApi;
        $this->longTermMemory = $longTermMemory;
    }

    public function processMessage(Request $request, MessageContext $messageContext)
    {
        $this->openAiApi->setApiKey(ApiHelper::getOpenAiApiKey());

        $user = Auth::user();
        $messageData = new MessageData($user, $request->all());

//        if (MessageHelper::isCommand($messageData)) {
//            $messageContext->setStrategy(new CommandMessage($messageData));
//        } else if (MessageHelper::isSnippet($messageData)) {
//            $messageContext->setStrategy(new SnippetMessage($messageData));
//        } else {
//            $messageContext->setStrategy(new OpenAiMessage($messageData));
//        }

        $result = $messageContext->handle();
        if($result['fullResponse']){
            return $this->responseJson($result['message'], $result['data'] ?? null, $result['manyResponse'] ?? false);
        }else{
            return $this->responseStream($result['message'], $messageData);
            // AutomaticTestOpenaiSnippet
//            if(array_key_exists('manyResponse', $result) && $result['manyResponse']){
//                foreach ($result['data'] as $testCase){
//                    return $this->responseStream($testCase['description']. 'Make unit test', $messageData);
//                }
//
//            }else{
//
//            }
        }
    }

    private function responseJson(string $text, array $data = null, bool $manyResponse = false) : JsonResponse
    {
        if ($text === 'empty') {
            $text = 'The error occurred. Message cannot be empty.';
        }

        if (is_null($text)) {
            $text = 'No command provided.';
        }
        $result = [
            'status' => 200,
           // 'type' => $this->typeMessage->value,
            'view' => $text,
            'data' => $data,
            'manyResponse' => $manyResponse
        ];

        return response()->json($result);
    }

    private function responseStream(string $systemPrompt, MessageData $messageData){

        $prompt = $messageData->message;
        $messageData->saveSystem($systemPrompt);

        return response()->stream(function () use ($prompt, $systemPrompt, $messageData) {
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            $stream = $this->openAiApi->chat($prompt, OpenAiModel::CHAT_GPT_3, $systemPrompt);
            $result = '';
            foreach ($stream as $response) {
                $message = $response->choices[0]->toArray();
                $message['id'] = $messageData->messageModel->id ?? $messageData->id;
                if(!empty($message['delta']['content'])){
                    $result .= $message['delta']['content'];
                }
                $this->sendSseMessage($message, 'message');
            }
            $messageData->saveResult($result);
        });
    }










    public function getHistory(){
        $results = Conversation::select(['id', 'title', 'updated_at'])
            ->where('avatar', Auth::user()->active_avatar)
            ->where('user_id', Auth::user()->id)
            ->whereNotNull('title')
            ->orderBy('id', 'desc')
            ->limit(13)
            ->get()
            ->map(function ($conversation) {
                return [
                    'id' => $conversation->id,
                    'title' => $conversation->title,
                    'date' => $conversation->updated_at->format('Y-m-d H:i:s')
                ];
            })
            ->toArray();
        return response()->json($results);
    }

    public function getConversation($id){
        $messages = MessageHelper::getAllConversationMessages($id);
        return response()->json($messages);
    }

    /**
     * Returns the list of available commands as a JSON response.
     * @return JsonResponse
     */
    public function getCommandList()
    {
        $commandList = $this->commandInvoker->getCommandList();
        return response()->json($commandList);
    }

    public function clearConversation(){
        MessageHelper::clearConversation();
        Auth::user()->update(['active_conversation' => null]);
        return response()->json([
            'success' => true
        ]);
    }

    public function getMessages(){
        $messages = MessageHelper::getAllConversationMessages();
        if (!isset($messages[1]) && isset($messages[0])) {
            $message = $messages[0];
            $conversation = Conversation::where('id', $message->conversation_id)->first();
            if($conversation && empty($conversation->title)){
                $title = $this->openAiApi->makeTitle($message->message);
                $conversation->title = $title;
                $conversation->save();
            }
        }

        return response()->json($messages);
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
        echo "data: " . json_encode($data) . "\n\n";
        ob_flush();
        flush();
    }
}
