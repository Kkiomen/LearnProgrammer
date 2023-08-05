<?php

namespace App\Models;

use App\Class\Assistant\Enum\AssistantType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    use HasFactory;
    protected $fillable = [
      'imgUrl', 'name', 'short_name', 'prompt', 'sort', 'type', 'public'
    ];

    protected $casts = [
        'type' => AssistantType::class
    ];
}
