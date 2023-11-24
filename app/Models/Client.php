<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'company_name',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'is_active',
        'address',
        'city',
        'postal_code',
        'country',
        'nip',
        'regon',
        'krs',
        'bank_account_number',
        'bank_name',
    ];
}
