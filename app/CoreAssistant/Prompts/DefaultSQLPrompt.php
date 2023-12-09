<?php

namespace App\CoreAssistant\Prompts;

use App\CoreAssistant\Abstract\Prompt;
use App\CoreAssistant\Config\TableConfig;
use App\CoreAssistant\Config\TableToPrompts\TableConfigHelper\TableConfigFieldType;
use App\CoreAssistant\Config\TableToPrompts\TablePrompt;

class DefaultSQLPrompt extends Prompt
{
    public static function getPrompt(array $tables = []): string
    {
        $listOfTables = '';
        if($tables !== []){
            foreach ($tables as $table){

                $tableData = self::getTableData($table);

                $listOfTables .= '### Tabela: ' . $tableData['table_name'] . "\n";

                foreach ($tableData['table_fields'] as $field){
                    $listOfTables .= $field['field_name'] . ' (' . $field['field_type']->value . '), ';
                }
            }

            $listOfTables .= ' \n';
        }
        return "
            Znając poniższe tabele postaraj się znaleźć potrzebne dla użytkownika wiadomości.

            " . $listOfTables . "

            # W nawiasach znajduje się pierwsza litera typu danych.
            np: ". TableConfigFieldType::getFieldTypesToPrompt() ."

            ##
            Jeśli typ pola to varchar albo text do wyszykuj za pomocą: LIKE '%XYZ%' (nie wiadomo czy to fragment czy cały element podał użytkownik)
            Gdzie XYZ to element

            ## Staraj się odpowiadać nazwami (zrozumiałymi dla użytkownika) niż identyfikatorami (o ile nie poprosi Cię oto użytkownik).
            Czyli naprzykład zamiast podawać identyfikator klienta podaj jego nazwe

            ## Dzisiaj jest: ". now() ."
            # Zwróć zapytanie SQL i tylko zapytanie SQL
        ";
    }

    protected static function getTableData(TablePrompt $table): ?array
    {
        $config = TableConfig::getTableConfig();

        $result = array_filter($config, function ($item) use ($table) {
            return $item['table_name'] === $table->value;
        });

        if(empty($result)){
            return null;
        }

        return reset($result);
    }
}
