<?php

namespace App\CoreErpAssistant\DeclarationClass\Events;

use App\CoreErpAssistant\Abstract\Event;
use App\CoreErpAssistant\Api\OpenAiApi;
use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Enum\OpenAiModel;
use App\CoreErpAssistant\Prompts\OrderSQLPrompt;
use App\CoreErpAssistant\Prompts\ResponseUserPrompt;
use App\CoreErpAssistant\Service\Event\EventResult;
use Illuminate\Support\Facades\DB;

class OrderEvent extends Event
{
    protected ?string $name = 'order';
    protected ?string $description = 'Pytania dotyczące zamówienia';
    protected array $triggers = ['zamówień', 'zamówienia', 'zamówienie'];


    public function __construct(
        private readonly OpenAiApi $openAiApi,
    ){}


    public function handle(MessageProcessor $messageProcessor): EventResult
    {
        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageProcessor->getMessageFromUser(),
            'systemPrompt' => OrderSQLPrompt::getPrompt()
        ], 'OrderEvent - Przygotowanie zapytania SQL');

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
        ], 'OrderEvent - Wygenerowany SQL');

        // Execute SQL to get result
        $result = DB::select(DB::raw($sql));
        $resultJson = json_encode($result);

        $systemPrompt = ResponseUserPrompt::getPrompt(
            question: $messageProcessor->getMessageFromUser(),
            resultSQL: $resultJson,
            usedSQl: $sql
        );

        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageProcessor->getMessageFromUser(),
            'systemPrompt' => $systemPrompt,
            'sql' => $sql,
            'resultSQL' => $resultJson
        ], 'OrderEvent - Przekazanie do prompta końcowego');

        // Preprare response to user
        $result = new EventResult();
        $result->setMessageProcessor($messageProcessor);
        $result->setResultResponseUserMessage($messageProcessor->getMessageFromUser());
        $result->setResultResponseSystemPrompt($systemPrompt);

        return $result;
    }
}
