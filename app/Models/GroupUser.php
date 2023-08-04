<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;
    protected $fillable = [
      'group_id', 'user_id', 'role_id', 'used_api', 'used_long_term'
    ];

    public function user(){
        return $this->hasOne(User::class,'id', 'user_id');
    }
}
