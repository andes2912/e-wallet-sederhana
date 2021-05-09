<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{saldo_user,User};
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

    // TopUp
    public function topUp(Request $request, $id)
    {
      $token = Auth::user()->token();
      if ($token) {

      $validator = Validator::make($request->all(),[
        'saldo'      => 'required',
      ]);

       if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $saldo = auth()->user()->saldo()->find($id);

        if (!$saldo) {
          return response()->json([
              'success' => false,
              'message' => 'Saldo with id ' . $id . ' not found'
          ]);
        }

        $updated = $saldo->update([
          'saldo' => $request->saldo
        ]);

        if ($updated)
            return response()->json([
                'success' => true,
                'saldo'   => $saldo
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Product could not be updated'
            ], 500);
      }
    }

}
