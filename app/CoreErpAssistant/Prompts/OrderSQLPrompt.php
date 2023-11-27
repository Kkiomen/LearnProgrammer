<?php

namespace App\CoreErpAssistant\Prompts;

use App\CoreErpAssistant\Abstract\Prompt;

class OrderSQLPrompt extends Prompt
{
    public static function getPrompt(): string
    {
        return "
            Znając poniższe tabele postaraj się znaleźć potrzebne dla użytkownika wiadomości.

            ### Tabela: combo_orders
            id (i), company_name (v), company_address (v), company_city (v), company_postal_code (v), company_country (v), company_phone (v), company_email (v), company_first_name (v), company_last_name, order_positions_count (i), company_nip (i), order_positions_price_net_total, order_positions_price_gross_total, order_positions_tax_value_total, invoice_symbol, created_at (t), updated_at (t)

            # W nawiasach znajduje się pierwsza litera typu danych.
            np: (v) - varchar, (i) - int, (d) - decimal, (t) - timestamp

            ##
            Jeśli typ pola to varchar albo text do wyszykuj za pomocą: LIKE '%XYZ%' (nie wiadomo czy to fragment czy cały element podał użytkownik)
            Gdzie XYZ to element

            ## Dzisiaj jest: ". now() ."
            # Zwróć zapytanie SQL i tylko zapytanie SQL
        ";
    }
}
