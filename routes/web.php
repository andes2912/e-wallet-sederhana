<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logic','LogicController@logic');

Route::post('/logic-reject','LogicController@prosesReject');
Route::post('/logic-tengah','LogicController@prosesTengah');
Route::post('/logic-kiri','LogicController@prosesKiri');
