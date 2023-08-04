<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LongTermMemoryContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id', 'content', 'tags', 'sync'
    ];
}
