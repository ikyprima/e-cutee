<?php

use Illuminate\Support\Facades\Route;
use Modules\Jabatan\Http\Controllers\JabatanController;
use Modules\Jabatan\Http\Controllers\JabatanOrganisasiController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware([])->prefix('v1')->group(function () {
    Route::apiResource('jabatan', controller: JabatanController::class)->names('jabatan');
    Route::apiResource('jabatan-organisasi', controller: JabatanOrganisasiController::class)->names('jabatan.organisasi');
});
