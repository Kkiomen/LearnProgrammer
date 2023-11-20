<?php

namespace App\Prompts;

class GenerateQuestionToQuizPromptHelper
{
    public static function getDesignPatterns(): array
    {
        return [
            'Factory Method (Metoda fabrykująca)',
            'Abstract Factory (Fabryka abstrakcyjna)',
            'Adapter (Adapter)',
            'Bridge (Most)',
            'Builder (Budowniczy)',
            'Prototype (Prototyp)',
            'Composite (Kompozyt)',
            'Decorator (Dekorator)',
            'Singleton (Singleton)',
            'Facade (Fasada)',
            'Flyweight (Pyłek)',
            'Proxy (Pełnomocnik)',
            'Chain of Responsibility (Łańcuch zobowiązań)',
            'Command (Polecenie)',
            'Interpreter (Interpreter)',
            'Iterator (Iterator)',
            'Mediator (Pośrednik)',
            'Memento (Pamiątka)',
            'Observer (Obserwator)',
            'State (Stan)',
            'Strategy (Strategia)',
            'Template Method (Metoda szablonowa)',
            'Visitor (Wizytator)',
        ];
    }

    public static function generateOptions(string $correctDesignPattern): array
    {
        $designPatterns = self::getDesignPatterns();
        $options = [];

        while (count($options) < 3) {
            $randomDesignPattern = $designPatterns[array_rand($designPatterns)];

            if ($randomDesignPattern !== $correctDesignPattern && !in_array($randomDesignPattern, $options)) {
                $options[] = $randomDesignPattern;
            }
        }

        $options[] = $correctDesignPattern;
        shuffle($options);

        return $options;
    }

    public static function getPrompt(string $chooseDesignPattern, array $usedTasks): string
    {
        $usedTasksString = '';

        if(!empty($usedTasks)) {
            $usedTasksString .= 'Podaj inny przykład niż: ';

            foreach ($usedTasks as $usedTask) {
                $usedTasksString .= '- '. $usedTask . ', ';
            }
        }

        $result =  'Potrzebuje zrobić test wzorców projektowych aby nauczyć się (przychodziło do głowy) używanie konkretnych wzorców projektowych w konkretnych sytuacjach.
Daj mi przykład pytanie, który można zadać użytkownikowi aby wybrał poprawny wzorzec projektowy. Podaj w pytaniu przykład złego kodu, którego zastosowanie wzorca poprawi go. Użyj do przedstawienia markdown. Do tego podaj mi możliwe 4 wzorce (przyciski do wyboru), pokaż mi która odpowiedź jest poprawna (może być tylko jedna)
A na samym końcu podaj wyjaśnienie.
Wyjaśnienie pokazuj w PHP i dodaj odpowiednią adnotacje markdown, że to ten język

###
Test przygotuj dla wzorca: "' . $chooseDesignPattern . '""
' . $usedTasksString . '
Chce wymyślne przykłady i nietypowe casey. Najlepiej podaj przykład złego napisania kodu i jakim wzorcem go poprawić
###
Odpowiedź podaj prawidłowy JSON do przetworzenia za pomocą poniższego formatu:
{
    "question": "(przedstawienie sytuacji, do użycia wzorca. Podaj źle napisany kod, którego najlepiej będzie zrefaktorować danym wzorcem. Wymyśl nietypowe sytuacje ale realne)",
    "explanation": "Wyjaśnienie wraz z przykładem implementacji w MARKDOWN (podając kod, dodaj informacje że chodzi tu o kod php)"
}

###
W odpowiedzi daj tylko json i nic więcej';

        return $result;
    }

    public static function stripJsonMarkdown($string) {
        // Używamy wyrażenia regularnego do usunięcia nagłówków i końcówek Markdown
        $cleanJson = preg_replace('/^```json\n|\n```$/', '', $string);

        // Zwracamy przetworzony ciąg znaków
        return $cleanJson;
    }
}
