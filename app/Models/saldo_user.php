<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saldo_user extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id','no_rek','no_hp','saldo'
    ];
}