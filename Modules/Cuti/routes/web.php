<?php

use Illuminate\Support\Facades\Route;
use Modules\Cuti\Http\Controllers\CutiController;
use Modules\Cuti\Http\Controllers\AjukanCutiController;
use Modules\Cuti\Http\Controllers\PersetujuanCutiController;
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
    Route::prefix('admin')->group(function() {
        Route::get('/cuti', [CutiController::class, 'index'])->name('admin-index-cuti');
        Route::get('/cuti/ajukan', [AjukanCutiController::class, 'AjukanCuti'])->name('admin-ajukan-cuti');
        Route::post('/ajukan-cuti', [AjukanCutiController::class, 'Store'])->name('admin-ajukan-cuti-simpan');

        Route::get('/cuti/persetujuan', [PersetujuanCutiController::class, 'index'])->name('admin-persetujuan-cuti');
    });
    
});
