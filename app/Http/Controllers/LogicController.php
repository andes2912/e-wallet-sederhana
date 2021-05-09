<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logic;

class LogicController extends Controller
{
    // index
    public function logic()
    {
      return view('logic.index');
    }

    // Proses
    public function proses(Request $request)
    {
      $request->validate([
        'number' => 'required'
      ]);

      $logic = new logic;
      $data = $logic->number = $request->number;

      //Selain bilangan prima; (b) mengandung angka 0;
      $cari = 0;

      $n = \substr($data,3);
      for ($i=2; $i <= $n - 1; $i++) {
        if ($n % $i == 0 && preg_match("/$cari/", $n)) {
          $logic->posisi = 'DEAD';
          $logic->number = $n;
        }
      }



      //Id bilangan prima; (b) tidak mengandung angka 0; (c) apabila
      //3 digit awal dihapus, maka tetap menjadi bilangan prima;

      // $tigaa = substr($data,3);
      // for ($a=2; $a <= $tigaa; $a++) {
      //   if ($tigaa % $a == 0 && !preg_match("/$cari/", $data)) {
      //     $logic->posisi = 'CENTRAL';
      //     $logic->number = $tigaa;
      //   }
      // }



      //Id bilangan prima; (b) tidak mengandung angka 0;
      //(c) apabila 3 (tiga) digit awal dihapus, 2 digit terakhir menjadi bilangan prima yang berurutan angkanya;

      $tiga = substr($data,4);
      $tig = substr($tiga,-1);
      for ($b=2; $b <= $tiga; $b++) {
        if ($tiga % $b == 0 && !preg_match("/$cari/", $data)) {
          $logic->posisi = 'LEFT';
          $logic->number = $tiga .$tig + 1;
        }
      }

      //Id bilangan prima; (b) tidak mengandung angka 0;
      //(c) apabila 3 (tiga) digit awal dihapus, 3 digit paling akhir merupakan bilangan yang sama
      // $tigas = substr($data,3);

      $logic->save();

      return redirect()->back();
    }
}
