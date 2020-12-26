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

// user
Route::post('register', 'ApiUserController@register');
Route::post('login', 'ApiUserController@login');
Route::get('user', 'ApiUserController@getAuthenticatedUser')->middleware('jwt.verify');

// Nasabah
Route::get('nasabah', 'ApiNasabahController@index')->middleware('jwt.verify');
Route::get('nasabah/riwayatuang', 'ApiNasabahController@riwayatUang')->middleware('jwt.verify');
Route::get('nasabah/riwayatbarang', 'ApiNasabahController@riwayatBarang')->middleware('jwt.verify');
Route::get('nasabah/riwayatpenjemputan', 'ApiNasabahController@riwayatPenjemputan')->middleware('jwt.verify');
Route::get('nasabah/penjemputan', 'ApiNasabahController@penjemputan')->middleware('jwt.verify');
Route::post('nasabah/penjemputan', 'ApiNasabahController@requestPenjemputan')->middleware('jwt.verify');

// pengurus1
Route::get('pengurus1', 'ApiPengurus1Controller@index')->middleware('jwt.verify');
Route::get('pengurus1/datajemput', 'ApiPengurus1Controller@dataJemput')->middleware('jwt.verify');
Route::get('pengurus1/harusjemput', 'ApiPengurus1Controller@harusJemput')->middleware('jwt.verify');
Route::get('pengurus1/riwayatjemput', 'ApiPengurus1Controller@riwayatJemput')->middleware('jwt.verify');
Route::get('pengurus1/detaildatajemput/{id}', 'ApiPengurus1Controller@detailDataJemput')->middleware('jwt.verify');
Route::get('pengurus1/terimajemput{id}', 'ApiPengurus1Controller@terimaJemput')->middleware('jwt.verify');
Route::get('pengurus1/selesaijemput{id}', 'ApiPengurus1Controller@selesaiJemput')->middleware('jwt.verify');
Route::get('pengurus1/tolakjemput{id}', 'ApiPengurus1Controller@tolakJemput')->middleware('jwt.verify');
Route::get('pengurus1/daftarnasabah', 'ApiPengurus1Controller@daftarNasabah')->middleware('jwt.verify');
Route::get('pengurus1/pendataan', 'ApiPengurus1Controller@jenisSampah')->middleware('jwt.verify');
Route::post('pengurus1/pendataan/{id}', 'ApiPengurus1Controller@pencatatan')->middleware('jwt.verify');
