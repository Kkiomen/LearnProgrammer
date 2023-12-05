<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\Abstract\Event;
use App\CoreAssistant\Api\OpenAiApi;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Enum\OpenAiModel;
use App\CoreAssistant\Prompts\CreateHeaderTablePrompt;
use App\CoreAssistant\Prompts\OrderSQLPrompt;
use App\CoreAssistant\Prompts\ResponseUserPrompt;
use App\CoreAssistant\Service\Event\EventResult;
use Illuminate\Support\Facades\DB;

class ListOrderEvent extends Event
{
    protected ?string $name = 'listDataDatabaseByTable';
    protected ?string $description = 'Wyświetlenie zamówień / produktów / klientów w formie tabeli. Np. wyświetl ostatnie zamówienia albo wyświetl coś w formie tabeli';
    protected array $triggers = ['wyświetl', 'lista', 'listy', 'wymień', 'listy', 'tabela', 'tabeli'];


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
        $messageUser = 'Napisz, że "Oto dane o które prosiłeś"';

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
