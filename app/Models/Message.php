<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id', 'conversation_id', 'message', 'result', 'type', 'prompt', 'system', 'avatar', 'snippet', 'sync'
    ];
}
