<?php

namespace App\CoreErpAssistant\DeclarationClass\Events\Basic;

use App\CoreErpAssistant\Abstract\Event;
use App\CoreErpAssistant\Api\OpenAiApi;
use App\CoreErpAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreErpAssistant\Enum\OpenAiModel;
use App\CoreErpAssistant\Prompts\OrderSQLPrompt;
use App\CoreErpAssistant\Prompts\ResponseUserPrompt;
use App\CoreErpAssistant\Service\Event\EventResult;
use Illuminate\Support\Facades\DB;

class NormalSQLEvent extends Event
{
    const MAX_ATTEMPTS = 3;

    public function __construct(
        private readonly OpenAiApi $openAiApi,
    ) {
    }

    public function handle(MessageProcessor $messageProcessor): EventResult
    {
        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageProcessor->getMessageFromUser(),
            'systemPrompt' => OrderSQLPrompt::getPrompt(),
        ], 'OrderEvent - Przygotowanie zapytania SQL');

        $attempt = 0;
        $success = false;
        while ($attempt < self::MAX_ATTEMPTS && !$success) {
            try {
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

                $success = true;

            } catch (\Exception $e) {
                // Prepare response to user
                $messageProcessor->getLoggerStep()->addStep([
                    'error' => $e->getMessage(),
                ], 'OrderEvent - Błąd SQL');

                $attempt++; // Increase attempt
            }
        }


        if (!$success) {
            // Prepare response to user
            $result = new EventResult();
            $result->setMessageProcessor($messageProcessor);
            $result->setResultResponseUserMessage('Napisz użytkownikowi że nie udało się znaleźć poprawnej odpowiedzi');
            $result->setResultResponseSystemPrompt('');

            return $result;
        }

        $systemPrompt = ResponseUserPrompt::getPrompt(
            question: $messageProcessor->getMessageFromUser(),
            resultSQL: $resultJson,
            usedSQl: $sql
        );

        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageProcessor->getMessageFromUser(),
            'systemPrompt' => $systemPrompt,
            'sql' => $sql,
            'resultSQL' => $resultJson,
        ], 'OrderEvent - Przekazanie do prompta końcowego');

        // Preprare response to user
        $result = new EventResult();
        $result->setMessageProcessor($messageProcessor);
        $result->setResultResponseUserMessage($messageProcessor->getMessageFromUser());
        $result->setResultResponseSystemPrompt($systemPrompt);

        return $result;
    }
}
