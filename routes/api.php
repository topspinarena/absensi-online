<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\RiwayatApiController;
use App\Http\Controllers\Api\AbsensiApiController;
use App\Http\Controllers\Api\IzinApiController;

/*
|--------------------------------------------------------------------------
| API Login
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthApiController::class, 'login']);

/*
|--------------------------------------------------------------------------
| API Protected
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileApiController::class, 'index']);

    // Riwayat Absensi
    Route::get('/riwayat', [RiwayatApiController::class, 'index']);

    // Absensi
    Route::post('/absensi/masuk', [AbsensiApiController::class, 'masuk']);
    Route::post('/absensi/keluar', [AbsensiApiController::class, 'keluar']);

    // Pengajuan Izin
    Route::get('/izin', [IzinApiController::class, 'index']);
    Route::post('/izin', [IzinApiController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthApiController::class, 'logout']);

});