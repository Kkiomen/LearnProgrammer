<?php

namespace App\CoreAssistant\Config\TableToPrompts;

enum TablePrompt: string
{
    case CLIENTS = 'CLIENTS';
    case PRODUCTS = 'PRODUCTS';
    case INVOICES = 'INVOICES';
    case INVOICE_POSITIONS = 'INVOICE_POSITIONS';
}
