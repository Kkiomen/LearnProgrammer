<?php

namespace App\CoreAssistant\Prompts;

use App\CoreAssistant\Abstract\Prompt;

class OrderSQLPrompt extends Prompt
{
    public static function getPrompt(): string
    {
        return "
            Znając poniższe tabele postaraj się znaleźć potrzebne dla użytkownika wiadomości.

            ### Tabela: orders
            id (i), client_id (i), invoice_symbol (v), invoice_place (v), invoice_date (date), payment_date (date), delivery_address (v), delivery_city (v), delivery_postal_code (v), delivery_country (v), delivery_phone (v), delivery_email (v), delivery_first_name (v), delivery_last_name (v), positions_count (i), positions_price_net_total (d), positions_price_gross_total (d)

            ### Tabela: order_positions
            id (id), order_id (i), product_id (i), quantity (i), price_net (d), price_gross (d), tax (d), price_net_total (d), price_gross_total (d), tax_value_total (d)

            ### Tabela: products
            id (i), name (v), price_net (d), price_gross (d)

            ### Tabela: clients
            id (i), company_name (v), first_name (v), last_name (v), email (v), phone_number (v), is_active (i), address (v), city (v), postal_code (v), country (v), nip (v), regon (v), krs (v), bank_account_number (v), bank_name (v)

            # W nawiasach znajduje się pierwsza litera typu danych.
            np: (v) - varchar, (i) - int, (d) - decimal, (t) - timestamp, (date) - date

            ##
            Jeśli typ pola to varchar albo text do wyszykuj za pomocą: LIKE '%XYZ%' (nie wiadomo czy to fragment czy cały element podał użytkownik)
            Gdzie XYZ to element

            ## Staraj się odpowiadać nazwami (zrozumiałymi dla użytkownika) niż identyfikatorami (o ile nie poprosi Cię oto użytkownik).
            Czyli naprzykład zamiast podawać identyfikator klienta podaj jego nazwe

            ## Dzisiaj jest: ". now() ."
            # Zwróć zapytanie SQL i tylko zapytanie SQL
        ";
    }
}
