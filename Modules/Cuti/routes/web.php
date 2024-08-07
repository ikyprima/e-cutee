<?php

use Illuminate\Support\Facades\Route;
use Modules\Cuti\Http\Controllers\CutiController;
use Modules\Cuti\Http\Controllers\AjukanCutiController;
use Modules\Cuti\Http\Controllers\PersetujuanCutiController;
use Modules\Cuti\Http\Controllers\PersetujuanKepalaController;
use Modules\Cuti\Http\Controllers\RekapCutiController;
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

});


Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function() {

//midleware pegawai dan admin
        Route::get('/cuti', [CutiController::class, 'index'])->name('admin-index-cuti');

        //midleware Pegawai
        Route::get('/cuti/ajukan', [AjukanCutiController::class, 'AjukanCuti'])->name('admin-ajukan-cuti');
        Route::post('/ajukan-cuti', [AjukanCutiController::class, 'Store'])->name('admin-ajukan-cuti-simpan');

        //midleware pegawai
        Route::get('/cuti/persetujuan', [PersetujuanCutiController::class, 'index'])->name('admin-persetujuan-cuti');
        Route::post('/cuti/persetujuan', [PersetujuanCutiController::class, 'Store'])->name('admin-persetujuan-cuti-simpan');
        Route::post('/cuti/persetujuan/lampiran', [AjukanCutiController::class, 'viewLampiran'])->name('admin-view-lampiran-cuti');

        //midleware pimpinan 
        Route::post('/cuti/persetujuan-pimpinan',[PersetujuanKepalaController::class,'Store'])->name('persetujuan-pimpinan');
    });

    //midleware Admin 
    Route::get('/rekap-cuti', [RekapCutiController::class, 'index'])->name('admin-rekap-cuti');
    Route::get('/list-pengajuan-cuti', [CutiController::class, 'index'])->name('admin-list-pengajuan-cuti');
    Route::get('/download-dokumen', [CutiController::class, 'download'])->name('admin-download-dokumen');

    //testing
    // Route::get('pdf', [CutiController::class,'pdfBlanko']); //contoh 
    // Route::get('word', [CutiController::class,'generateDocumentIzinCuti']); //contoh 

    
    
});