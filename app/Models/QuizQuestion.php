<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'lang',
        'question',
        'options',
        'correct_answer',
        'explanation'
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
