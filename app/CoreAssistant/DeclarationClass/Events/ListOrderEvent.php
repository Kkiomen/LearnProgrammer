<?php

namespace App\CoreAssistant\DeclarationClass\Events;

use App\CoreAssistant\Abstract\Event;
use App\CoreAssistant\Adapter\LLM\LanguageModel;
use App\CoreAssistant\Adapter\LLM\LanguageModelSettings;
use App\CoreAssistant\Adapter\LLM\LanguageModelType;
use App\CoreAssistant\Core\Exceptions\FailedGenerateDataException;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Prompts\CreateHeaderTablePrompt;
use App\CoreAssistant\Prompts\OrderSQLPrompt;
use App\CoreAssistant\Service\Event\EventResult;
use Illuminate\Support\Facades\DB;

class ListOrderEvent extends Event
{
    const MAX_ATTEMPTS = 3;

    protected ?string $name = 'listDataDatabaseByTable';
    protected ?string $description = 'Wyświetlenie zamówień / produktów / klientów w formie tabeli. Np. wyświetl ostatnie zamówienia albo wyświetl coś w formie tabeli';
    protected array $triggers = ['wyświetl', 'lista', 'listy', 'wymień', 'listy', 'tabela', 'tabeli'];


    public function __construct(
        private readonly LanguageModel $languageModel,
    ){}


    public function handle(MessageProcessor $messageProcessor): EventResult
    {
        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageProcessor->getMessageFromUser(),
            'systemPrompt' => OrderSQLPrompt::getPrompt()
        ], 'ListOrderEvent - Przygotowanie zapytania SQL');


        try{

            $dataTable = $this->generateDataForTable($messageProcessor->getMessageFromUser(), OrderSQLPrompt::getPrompt(), $messageProcessor);
            $firstRowTable = json_encode($dataTable['result'][0]);
            $headerTable = $this->generateHeader($firstRowTable, CreateHeaderTablePrompt::getPrompt($dataTable['sql']), $messageProcessor);

            $table = [];
            $table[] = $headerTable;
            $table = array_merge($table, $dataTable['result']);

        }catch (\Exception $e){
            $result = new EventResult();
            $result->setMessageProcessor($messageProcessor);
            $result->setResultResponseUserMessage('Napisz użytkownikowi że nie udało się znaleźć poprawnej odpowiedzi');
            $result->setResultResponseSystemPrompt('');

            return $result;
        }

        $systemPrompt = '';
        $messageUser = 'Napisz, że "Oto dane o które prosiłeś"';

        $messageProcessor->getLoggerStep()->addStep([
            'prompt' => $messageUser,
            'systemPrompt' => $systemPrompt,
            'sql' => $dataTable['sql'],
            'resultSQL' => $dataTable['resultJson'],
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

    private function generateDataForTable(string $messageUser, string $prompt, MessageProcessor $messageProcessor): ?array
    {
        $attempt = 0;
        $success = false;
        $resultJson = null;
        while ($attempt < self::MAX_ATTEMPTS && !$success) {
            try {
                // Create SQL
                $sql = $this->languageModel->generate(
                    prompt: $messageUser,
                    systemPrompt: $prompt,
                    settings: (new LanguageModelSettings())->setLanguageModelType(LanguageModelType::INTELLIGENT)->setTemperature(0.3)
                );

                $messageProcessor->getLoggerStep()->addStep([
                    'prompt' => $messageProcessor->getMessageFromUser(),
                    'systemPrompt' => OrderSQLPrompt::getPrompt(),
                    'sql' => $sql,
                ], 'ListOrderEvent - Wygenerowany SQL');


                // Execute SQL to get result
                $result = DB::select(DB::raw($sql));
                $resultJson = json_encode($result);

                $success = true;
            } catch (\Exception $e) {
                // Prepare response to user
                $messageProcessor->getLoggerStep()->addStep([
                    'error' => $e->getMessage(),
                ], 'ListOrderEvent - Błąd SQL');

                $attempt++; // Increase attempt
            }
        }

        if (!$success){
            throw new FailedGenerateDataException();
        }

        return [
            'resultJson' => $resultJson,
            'result' => $result,
            'sql' => $sql
        ];
    }

    private function generateHeader(string $prompt, string $systemPrompt, MessageProcessor $messageProcessor): ?array
    {
        $attempt = 0;
        $success = false;
        $generatedHeader = null;
        while ($attempt < self::MAX_ATTEMPTS && !$success) {
            try {

                $generatedHeader = $this->languageModel->generate(
                    prompt: $prompt,
                    systemPrompt: $systemPrompt,
                    settings: (new LanguageModelSettings())->setLanguageModelType(LanguageModelType::INTELLIGENT)->setTemperature(0.7)
                );

                $messageProcessor->getLoggerStep()->addStep([
                    'prompt' => $prompt,
                    'systemPrompt' => $systemPrompt,
                    'header' => $generatedHeader,
                ], 'ListOrderEvent - Wygenerowany header');

                $generatedHeader = json_decode($generatedHeader, true);
                $success = true;
            } catch (\Exception $e) {
                // Prepare response to user
                $messageProcessor->getLoggerStep()->addStep([
                    'error' => $e->getMessage(),
                ], 'ListOrderEvent - Błąd SQL');

                $attempt++; // Increase attempt
            }
        }

        if (!$success){
            throw new FailedGenerateDataException();
        }

        return $generatedHeader;
    }
}
