<?php

namespace App\Services;
use App\Abstract\Command;
use App\Class\OpenAiMessage;
use App\Enum\TypeMessage;
use App\Models\Message;
use \Illuminate\Http\Request;
class ChatService
{

    private CommandInvoker $commandInvoker;
    private OpenAiMessage $openAiMessage;
    private SnippetService $snippetService;

    /**
     * @param CommandInvoker $commandInvoker
     */
    public function __construct(CommandInvoker $commandInvoker, OpenAiMessage $openAiMessage, SnippetService $snippetService)
    {
        $this->commandInvoker = $commandInvoker;
        $this->openAiMessage = $openAiMessage;
        $this->snippetService = $snippetService;
    }


    public function handleMessage(Request $request)
    {
        $messageModel = null;

        if(!empty($request->get('id'))){
           $messageModel = Message::where('id', $request->get('id'))->first();
           $message = $messageModel->message;
           $message = self::preparePrompt($message);
        }else{
            $message = $request->get('message');
            $message = self::preparePrompt($message);
            $this->openAiMessage->addMessage($message,null, $request->get('avatar'));
        }

        if(empty($message)){
            return ['message' => 'empty'];
        }

        if($this->isCommand($message)){
            $resultCommand = $this->commandInvoker->executeCommand($message);
            $this->openAiMessage->addResult($resultCommand['message'], TypeMessage::COMMAND,null,null, $request->get('id'));
            return $resultCommand;
        }

        if($this->isSnippet($request, $messageModel)){
            $resultSnippet = $this->snippetService->getResultSnippet($request, $messageModel);
            if($resultSnippet['full']){
                $this->openAiMessage->addResult($resultSnippet['message'], TypeMessage::SNIPPET, $resultSnippet['prompt'],null, $request->get('id'));
            }
            return $resultSnippet;
        }



        return ['message' => null];
    }

    /**
     * Check if message is command
     * @param string $message
     * @return bool
     */
    private function isCommand(string $message): bool
    {
        return !empty($message) && $message[0] === Command::CHARACTER_STARTING_COMMAND;
    }

    /**
     * Check if message used Snippet
     * @param Request $request
     * @return bool
     */
    private function isSnippet(Request $request, ?Message $message): bool
    {
        return ($request->get('mode') !== null) || (isset($message) && $message->type === 'snippet');
    }

    public static function preparePrompt($message){
        if (str_contains($message, "{now}")) {
            $message = str_replace("{now}", now(), $message);
        }

        return $message;
    }
}
