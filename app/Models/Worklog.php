<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worklog extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id', 'description', 'duration_minutes', 'issue_name', 'created_at'
    ];
}
