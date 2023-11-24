<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'quantity',
        'price_net',
        'price_gross',
        'tax',
        'price_net_total',
        'price_gross_total',
        'tax_value_total',
    ];
}
