<?php
namespace App\Prompts;

class SelectOrderPrompt
{
    public static function getPrompt(): string
    {
        return '
            Znając poniższe tabele postaraj się znaleźć potrzebne dla użytkownika wiadomości.
            ### Tabela: combo_orders
            id, company_name, company_address, company_city, company_postal_code, company_country, company_phone, company_email, company_first_name, company_last_name, order_positions_count, company_nip, order_positions_price_net_total, order_positions_price_gross_total, order_positions_tax_value_total, invoice_symbol, created_at, updated_at

            ## Dzisiaj jest '.now().'

            # Zwróć zapytanie SQL i tylko zapytanie SQL
         ';
    }
}
