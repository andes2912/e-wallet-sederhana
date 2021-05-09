<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id','user_tujuan_id','no_transaksi','amount','type_transfer','jenis_transfer','status'
    ];
}
