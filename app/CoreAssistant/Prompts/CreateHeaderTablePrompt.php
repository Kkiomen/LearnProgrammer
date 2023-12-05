<?php

namespace App\CoreAssistant\Prompts;

class CreateHeaderTablePrompt
{
    public static function getPrompt(string $usedSQL): string
    {
        return '
                Stwórz mi pierwszy obiekt reprezentujący nagłówek tabeli. Na podstawie obiektu przekazanego przez użytkownika stwórz nagłówek tabeli. Ilość kolumn w nagłówku musi odpowiadać ilości elementów w obiekcie

                ### Dla ułatwienia użyty: SQL:
                '.$usedSQL.'

                ### Wynik:
                [{"element obiektu":"tłumaczenie",....}]
                np:
                [{"id":"id", "address": "Adres",....}]


                ###
                Zwróć nagłówek w formie JSON i tylko JSON';
    }
}
