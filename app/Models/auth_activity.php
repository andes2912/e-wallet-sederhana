<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auth_activity extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id','ip','user_agent','method'
    ];
}
