<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintList extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'time',
        'result'
    ];
}
