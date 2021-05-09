<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{saldo_user,User,log_transaksi};
use Illuminate\Support\Facades\Validator;
use Auth;

class SaldoController extends Controller
{
    //cek saldo
    public function index(Request $request)
    {

      $token = Auth::user()->token();

      if ($token) {
        $saldo = auth()->user()->saldo;

        return \response()->json([
          'saldo' => $saldo
        ]);
      }
    }

    //Mutasi transaksi
   public function mutasi()
   {
      $token = Auth::user()->token();

      if ($token) {
        $mutasi = log_transaksi::where('user_id', Auth::id())->get();

        return \response()->json([
          'mutasi' => $mutasi
        ]);
      }
   }


}
