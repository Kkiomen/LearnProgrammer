<?php

namespace App\Abstract;
use App\Class\OpenAiMessage;
use App\Enum\TypeMessage;
use App\Helpers\MessageHelper;
use \App\Models\Message;
use App\Models\User;

class MessageData
{
    public ?int $id = null;
    public ?int $conversationId = null;
    public array $payload = [];
    public ?string $message = null;
    public ?string $avatar = null;
    public ?bool $useLongMemory = null;
    public ?string $mode = null;
    public ?Message $messageModel = null;
    public string $typeMessage = TypeMessage::TEXT->value;

    public User $user;

    /**
     * @param array $payload
     */
    public function __construct(User $user, array $payload)
    {
        $this->payload = $payload;
        $this->user = $user;
        $this->prepareDataMessage($payload);
    }

    public function saveSystem(string $prompt){
        $this->messageModel->system = $prompt;
        $this->messageModel->save();
    }

    public function savePrompt(string $prompt){
        $this->messageModel->prompt = $prompt;
        $this->messageModel->save();
    }

    public function saveResult(string $result){
        $this->messageModel->result = $result;
        $this->messageModel->save();
    }


    /**
     * Prepares message data based on the submitted array payload.
     * @param array $payload
     * @return void
     */
    private function prepareDataMessage(array $payload): bool
    {
        if(array_key_exists('id', $payload)){
            $message = Message::find($payload['id']);
            if($message){
                $this->messageModel = $message;
                $this->id = $message->id;
                return $this->parseData($message);
            }
        }

        $message = new Message();
        $this->messageModel = $message;
        $message->message = $payload['message'];
        $message->use_long_term = $payload['useAi'];
        $message->avatar = $payload['avatar'];
        $message->snippet = $payload['mode'];
        $message->user_id = $this->user->id;
        $message->type = TypeMessage::TEXT->value;
        $message->conversation_id = MessageHelper::getConversation($this->user)->id;

        $this->id = $message->id ?? null;
        return $this->parseData($message);
    }

    /**
     * Parse data From Message to MessageData
     * @param Message $message
     * @return true
     */
    private function parseData(Message $message): bool
    {
        $this->message = $message->message;
        $this->useLongMemory = $message->use_long_term;
        $this->avatar = $message->avatar;
        $this->mode = $message->snippet;
        $this->typeMessage = $message->type;
        $this->conversationId = $message->conversation_id;
        return true;
    }

}
