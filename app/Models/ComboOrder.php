<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'company_name',
        'company_address',
        'company_postal_code',
        'company_city',
        'company_country',
        'company_phone',
        'company_email',
        'company_first_name',
        'company_last_name',
        'order_positions_count',
        'order_positions_price_net_total',
        'order_positions_price_gross_total',
        'order_positions_tax_value_total',
        'invoice_symbol',
    ];
}
