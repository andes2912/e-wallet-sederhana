<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('register','API\Auth\AuthController@register');
Route::post('login','API\Auth\AuthController@login');
Route::post('createreset','API\Auth\PasswordResetController@createreset')->middleware('auth:api');
Route::post('reset','API\Auth\PasswordResetController@reset')->middleware('auth:api');
Route::get('/logout', 'API\Auth\PasswordResetController@logout')->middleware('auth:api');

// Cek saldo
Route::get('cek-saldo','API\Account\SaldoController@index')->middleware('auth:api');

// Trsanksi
Route::post('topup','API\Account\TransaksiController@topup')->middleware('auth:api'); //Topup
Route::post('withdraw','API\Account\TransaksiController@withdraw')->middleware('auth:api'); //Withdraw
Route::post('transfer','API\Account\TransaksiController@transfer')->middleware('auth:api'); //Transfer ke sesama pengguna

Route::get('show-transaksi/{id}','API\Account\TransaksiController@showTransaksi')->middleware('auth:api'); //show transaksi by id
Route::put('proses-transaksi/{id}','API\Account\TransaksiController@prosesTransksi'); //Proses transaksi ubah status


