<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logic;

class LogicController extends Controller
{
    // index
    public function logic()
    {
      $data = logic::all();
      return view('logic.index', compact('data'));
    }

    // Proses
    public function prosesReject(Request $request)
    {
      $request->validate([
        'number' => 'required'
      ]);

      $logic = new logic;
      $data = $logic->number = $request->number;

      //Selain bilangan prima; (b) mengandung angka 0;
      $cari = 0;

      for ($i=2; $i <= (int)$data - 1; $i++) {
        if ($data % $i == 0 && preg_match("/$cari/", $data)) {
          $logic->posisi = 'DEAD';
          $logic->number = $data;
        }
      }

      $logic->save();
      return redirect()->back();
    }

    public function prosesTengah(Request $request)
    {
      //Id bilangan prima; (b) tidak mengandung angka 0; (c) apabila
      //3 digit awal dihapus, maka tetap menjadi bilangan prima;

      $request->validate([
        'number' => 'required'
      ]);

      $cari = 0;
      $logic = new logic;
      $data = $logic->number = $request->number;

      $tigaa = substr($data,3);
      for ($a=2; $a <= (int)$tigaa; $a++) {
        if ($tigaa % $a == 0 && !preg_match("/$cari/", $data)) {
          $logic->posisi = 'CENTRAL';
          $logic->number = $tigaa;
        }
      }

      $logic->save();
      return redirect()->back();
    }

    public function prosesKiri(Request $request)
    {
      //Id bilangan prima; (b) tidak mengandung angka 0;
      //(c) apabila 3 (tiga) digit awal dihapus, 2 digit terakhir menjadi bilangan prima yang berurutan angkanya;

      $request->validate([
        'number' => 'required'
      ]);

      $cari = 0;
      $logic = new logic;
      $data = $logic->number = $request->number;

      $tiga = substr($data,4);
      $tig = substr($tiga,-1);
      for ($b=2; $b <= (int)$tiga; $b++) {
        if ($tiga % $b == 0 && !preg_match("/$cari/", $data)) {
          $logic->posisi = 'LEFT';
          $logic->number = $tiga .$tig + 1;
        }
      }

      $logic->save();
      return redirect()->back();
    }
}
