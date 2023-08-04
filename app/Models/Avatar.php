<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;
    protected $fillable = [
        'img', 'name', 'short_name', 'type', 'category', 'prompt'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
