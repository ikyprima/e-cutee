<?php

use Illuminate\Support\Facades\Route;
use Modules\Pegawai\Http\Controllers\PegawaiController;

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

Route::group([], function () {
    Route::resource('pegawai', PegawaiController::class)->names('pegawai');
    Route::post('/pegawai/add-hirarki', [PegawaiController::class, 'addHirarki'])->name('pegawai.add.hirarki');
});
