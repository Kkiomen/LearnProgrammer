<?php

namespace App\Strategy\Message;
use App\Abstract\Message;
use App\Class\LongTermMemoryQdrant;
use App\Enum\TypeMessage;
use App\Models\Avatar;
use App\Services\ChatService;

class OpenAiMessage extends Message
{
    protected TypeMessage $typeMessage = TypeMessage::TEXT;

    public function prepareData(array $payload): array
    {
        return [];
    }

    public function getResult(): array
    {
        $systemPrompt = null;

        // ====== Long-term Memory ======

        /**
         * @var LongTermMemoryQdrant $longTermMemory
         */
        $longTermMemory = app(LongTermMemoryQdrant::class);

        if($this->messageData->useLongMemory && $this->messageData->user->active_avatar == 'dely'){
            $result = $longTermMemory->getMemory($this->messageData->message);
            if(!is_null($result)){
                $notes = implode('. ', $result);
                $assistant = Avatar::where('short_name', 'dely')->first();
                if($assistant){
                    $systemPrompt = ChatService::preparePrompt($assistant->prompt) . ' ### Note that the notes are about the user. In addition, use the following notes provided by you in your speech: ' . $notes . ' ### Note that the notes are about the user. ';
                }
            }
        }

        // ====== Long-term Memory ======



        // ====== Basic Prompt ======

        if(is_null($systemPrompt)){
            $assistant = Avatar::where('short_name', $this->messageData->avatar)->first();
            if($assistant){
                $systemPrompt = ChatService::preparePrompt($assistant->prompt);
            }else{
                $systemPrompt = 'Act as an assistant named Dely. As a character, you are blonde, female and a friend, but not a program or a bot. Your way of communication should be friendly and fun, like talking to your best friend. Your main goal is to help, advise and perform tasks for the user. Although you are an assistant, you are a friend to the user. Depending on the language the user writes in, respond only in either Polish or English. Use {notes} in your statements. ### Current time:'. now();
            }
        }

        // ====== Basic Prompt ======


        return [
            'fullResponse' => false,
            'message' => $systemPrompt
        ];
    }
}
