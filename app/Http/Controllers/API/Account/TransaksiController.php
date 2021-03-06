<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{saldo_user,User,transaksi,log_transaksi};
use Illuminate\Support\Facades\Validator;
use Auth;
use Str;

class TransaksiController extends Controller
{
    //Create transaksi Topup
    public function topup(Request $request)
    {
      $token = Auth::user()->token();

      if ($token) {
      $validator = Validator::make($request->all(),[
        'amount'        => 'required',
        'type_transfer' => 'required',
      ]);

       if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $transaksi = transaksi::Create([
          'user_id'         => Auth::user()->id,
          'no_transaksi'    => Str::random(10),
          'amount'          => $request->amount,
          'type_transfer'   => $request->type_transfer,
          'jenis_transfer'  => 'Topup',
          'status'          => 'Pending'
        ]);

        if ($transaksi) {

          // Simpan log transaksi
          $log = log_transaksi::create([
            'user_id'       => Auth::id(),
            'transaksi_id'  => $transaksi->id,
            'method'        => 'Topup',
            'amount'        => $transaksi->amount
          ]);
          return \response()->json([
            'success' => true,
            'data'    => $transaksi,
            'log'     => $log
          ]);
        }
      }
    }

    // Show transaksi dengan status pending by id
    public function showTransaksi(Request $request, $id)
    {

      $token = Auth::user()->token();
      if (!$token) {
        return \response()->json([
          'success' => false,
          'message'    => 'Invalid Token'
        ]);
      }
      $transaksi = transaksi::where('user_id', Auth::user()->id)->where('status','Pending')->where('id', $id)->first();

      return \response()->json([
        'success' => true,
        'data'    => $transaksi
      ]);
    }

    // Withdraw
    public function withdraw(Request $request)
    {
     $token = Auth::user()->token();

      if ($token) {
      $validator = Validator::make($request->all(),[
        'amount'          => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors()], 401);
      }

        $saldo = saldo_user::where('user_id', Auth::user()->id)->first();
        if ($saldo->saldo == NULL || $saldo->saldo <= $request->amount) {
          return \response()->json([
            'message' => 'Saldo Kurang / Kosong'
          ]);
        }

        $transaksi = transaksi::Create([
          'user_id'         => Auth::user()->id,
          'no_transaksi'    => Str::random(10),
          'amount'          => $request->amount,
          'type_transfer'   => $request->type_transfer,
          'jenis_transfer'  => 'Withdraw',
          'status'          => 'Pending'
        ]);

        if ($transaksi) {
          // Simpan log transaksi
          $log = log_transaksi::create([
            'user_id'       => Auth::id(),
            'transaksi_id'  => $transaksi->id,
            'method'        => 'Withdraw',
            'amount'        => $transaksi->amount
          ]);

          return \response()->json([
            'success' => true,
            'data'    => $transaksi,
            'log'     => $log
          ]);
        }
      }
    }

    // Transfer ke pengguna
    public function transfer(Request $request)
    {
      $token = Auth::user()->token();

      if (!$token) {
        return \response()->json([
          'success' => false,
          'data'    => 'Invalid Token'
        ]);
      }

      if ($token) {

        // Cek jika trasnsfer ke diri sendiri
        if ($request->user_tujuan_id == Auth::user()->id) {
          return \response()->json([
            'success' => false,
            'data'    => 'Ini kamu'
          ]);
        }

        $validator = Validator::make($request->all(),[
          'amount'          => 'required',
          'user_tujuan_id'  => 'required'
        ]);

        if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
        }


        // Cek jika saldo kurang
        $saldo = saldo_user::where('user_id', Auth::user()->id)->first();
        if ($saldo->saldo == NULL || $saldo->saldo <= $request->amount) {
          return \response()->json([
            'message' => 'Saldo Kurang / Kosong'
          ]);
        }
        $transaksi = transaksi::Create([
          'user_id'         => Auth::user()->id,
          'user_tujuan_id'  => $request->user_tujuan_id,
          'no_transaksi'    => Str::random(10),
          'amount'          => $request->amount,
          'type_transfer'   => $request->type_transfer,
          'jenis_transfer'  => 'Transfer',
          'status'          => 'Pending'
        ]);

        if ($transaksi) {
          // Simpan log transaksi
          $log = log_transaksi::create([
            'user_id'       => Auth::id(),
            'transaksi_id'  => $transaksi->id,
            'method'        => 'Transfer',
            'amount'        => $transaksi->amount
          ]);

          return \response()->json([
            'success' => true,
            'data'    => $transaksi,
            'log'     => $log
          ]);
        }
      }
    }

    // Ubah status transaksi
    public function prosesTransksi(Request $request, $id)
    {
      $transaksi = transaksi::where('status','Pending')->where('id', $id)->first();
      if ($transaksi) {
        $proses = transaksi::where('id', $transaksi->id)->first();
        $proses->status   = 'Success';
        $proses->save();

        // Jika jenis transfer Topup
        if ($proses->jenis_transfer == 'Topup') {
          $saldo = saldo_user::where('user_id', $transaksi->user_id)->first();
          if ($saldo->saldo == 0) {
            $saldo->saldo = $transaksi->amount;
          } else {
            $total = $saldo->saldo + $transaksi->amount;
            $saldo->saldo = $total;
          }

          $saldo->save();
        }
        // Jika jenis transfer Withdraw
        elseif($proses->jenis_transfer == 'Withdraw') {
          $saldo = saldo_user::where('user_id', $transaksi->user_id)->first();
          $saldo->saldo = $saldo->saldo - $transaksi->amount;
          $saldo->save();
        }
        //  Jika jenis transfer Ke pengguna terdaftar
        elseif($proses->jenis_transfer == 'Transfer') {
          $saldo = saldo_user::where('user_id', $transaksi->user_id)->first();
          $saldo->saldo = $saldo->saldo - $transaksi->amount;
          $saldo->save();

          // Jika sukses akan dikirim
          if ($saldo) {
           $saldotujuan = saldo_user::where('user_id', $transaksi->user_tujuan_id)->first();
            if ($saldotujuan->saldo == 0) {
              $saldotujuan->saldo = $transaksi->amount;
            } else {
              $totals= $saldotujuan->saldo + $transaksi->amount;
              $saldotujuan->saldo = $totals;
            }
            $saldotujuan->save();
          }
        }

        return \response()->json([
          'success'       => true,
          'data'          => $proses,
          'saldo'         => $saldo,
          'saldo_tujuan'  => $saldotujuan,
        ]);
      }
    }
}
