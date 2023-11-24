<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'invoice_symbol',
        'invoice_date',
        'invoice_place',
        'payment_date',
        'delivery_name',
        'delivery_address',
        'delivery_city',
        'delivery_postal_code',
        'delivery_country',
        'delivery_phone',
        'delivery_email',
        'delivery_first_name',
        'delivery_last_name',
    ];
}
