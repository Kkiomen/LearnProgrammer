<?php

namespace App\CoreAssistant\DeclarationClass\Events\Basic;

use App\CoreAssistant\Abstract\Event;
use App\CoreAssistant\Adapter\LLM\LanguageModel;
use App\CoreAssistant\Adapter\LLM\LanguageModelSettings;
use App\CoreAssistant\Adapter\LLM\LanguageModelType;
use App\CoreAssistant\Adapter\Repository\Interface\RepositorySqlInterface;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Prompts\OrderSQLPrompt;
use App\CoreAssistant\Prompts\ResponseUserPrompt;
use App\CoreAssistant\Service\Event\EventResult;

class NormalSQLEvent extends Event
{
    const MAX_ATTEMPTS = 3;

    public function __construct(
        private readonly LanguageModel $languageModel,
        private readonly RepositorySqlInterface $repositorySql
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
                $sql = $this->languageModel->generate(
                    prompt: $messageProcessor->getMessageFromUser(),
                    systemPrompt: OrderSQLPrompt::getPrompt(),
                    settings: (new LanguageModelSettings())->setLanguageModelType(LanguageModelType::INTELLIGENT)->setTemperature(0.5)
                );

                $messageProcessor->getLoggerStep()->addStep([
                    'prompt' => $messageProcessor->getMessageFromUser(),
                    'systemPrompt' => OrderSQLPrompt::getPrompt(),
                    'sql' => $sql,
                ], 'OrderEvent - Wygenerowany SQL');

                // Execute SQL to get result
                $result = $this->repositorySql->select($sql);
                $resultJson = json_encode($result);

                $messageProcessor->getLoggerSql()->addQuerySql($sql);
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

        // Prepare response to user
        $result = new EventResult();
        $result->setMessageProcessor($messageProcessor);
        $result->setResultResponseUserMessage($messageProcessor->getMessageFromUser());
        $result->setResultResponseSystemPrompt($systemPrompt);

        return $result;
    }
}
