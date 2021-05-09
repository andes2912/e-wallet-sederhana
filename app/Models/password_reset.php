<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class password_reset extends Model
{
  public $timestamps = false;

    use HasFactory;
    protected $fillable = [
        'email', 'token'
    ];
}
