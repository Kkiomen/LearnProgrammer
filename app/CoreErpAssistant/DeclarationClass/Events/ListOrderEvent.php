<?php

namespace App\CoreErpAssistant\DeclarationClass\Events;

use App\CoreErpAssistant\Abstract\Event;
use App\CoreErpAssistant\Api\OpenAiApi;
use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Enum\OpenAiModel;
use App\CoreErpAssistant\Prompts\CreateHeaderTablePrompt;
use App\CoreErpAssistant\Prompts\OrderSQLPrompt;
use App\CoreErpAssistant\Prompts\ResponseUserPrompt;
use App\CoreErpAssistant\Service\Event\EventResult;
use Illuminate\Support\Facades\DB;

class ListOrderEvent extends Event
{
    protected ?string $name = 'listOrder';
    protected ?string $description = 'Wyświetlenie zamówień w formie tabeli. Np. wyświetl ostatnie zamówienia';
    protected array $triggers = ['zamówień', 'zamówienia', 'zamówienie'];


    public function __construct(
        private readonly OpenAiApi $openAiApi,
    ){}


    public function handle(MessageProcessor $messageProcessor): EventResult
    {
        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageProcessor->getMessageFromUser(),
            'systemPrompt' => OrderSQLPrompt::getPrompt()
        ], 'ListOrderEvent - Przygotowanie zapytania SQL');

        // Create SQL
        $sql = $this->openAiApi->completionChat(
            message: $messageProcessor->getMessageFromUser(),
            systemPrompt: OrderSQLPrompt::getPrompt(),
            model: OpenAiModel::GPT_4
        );

        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageProcessor->getMessageFromUser(),
            'systemPrompt' => OrderSQLPrompt::getPrompt(),
            'sql' => $sql,
        ], 'ListOrderEvent - Wygenerowany SQL');

        // Execute SQL to get result
        $result = DB::select(DB::raw($sql));
        $resultJson = json_encode($result);

        $message = json_encode($result[0]);
        $system = CreateHeaderTablePrompt::getPrompt($sql);

        $header =  $this->openAiApi->completionChat(
            message: $message,
            systemPrompt: $system,
            model: OpenAiModel::CHAT_GPT_3
        );

        $table = [];

        $table[] = json_decode($header, true)[0];
        $table = array_merge($table, $result);

        $systemPrompt = '';
        $messageUser = 'Napisz, że już wyświetlasz informacje i nic więcej';

        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageUser,
            'systemPrompt' => $systemPrompt,
            'sql' => $sql,
            'resultSQL' => $resultJson,
            'table' => json_encode($table)
        ], 'ListOrderEvent - Przekazanie do prompta końcowego');

        // Preprare response to user
        $result = new EventResult();
        $result->setMessageProcessor($messageProcessor);
        $result->setResultResponseUserMessage($messageUser);
        $result->setResultResponseSystemPrompt($systemPrompt);
        $result->setResultResponseTable($table);

        return $result;
    }
}
