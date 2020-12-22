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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'ApiUserController@register');
Route::post('login', 'ApiUserController@login');
Route::get('user', 'ApiUserController@getAuthenticatedUser')->middleware('jwt.verify');

// Nasabah
Route::get('nasabah', 'ApiNasabahController@index')->middleware('jwt.verify');
Route::get('riwayatuang', 'ApiNasabahController@riwayatUang')->middleware('jwt.verify');
Route::get('riwayatbarang', 'ApiNasabahController@riwayatBarang')->middleware('jwt.verify');
Route::get('riwayatpenjemputan', 'ApiNasabahController@riwayatPenjemputan')->middleware('jwt.verify');
Route::get('penjemputan', 'ApiNasabahController@penjemputan')->middleware('jwt.verify');
Route::post('penjemputan', 'ApiNasabahController@requestPenjemputan')->middleware('jwt.verify');