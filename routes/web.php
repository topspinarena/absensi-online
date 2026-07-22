<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SettingLokasiController;
Route::redirect('/', '/login');
/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('karyawan', KaryawanController::class);

    Route::get('/setting-lokasi', [SettingLokasiController::class, 'index'])
        ->name('setting-lokasi.index');

    Route::post('/setting-lokasi', [SettingLokasiController::class, 'update'])
        ->name('setting-lokasi.update');
        
    Route::get('/riwayat-absensi', [AbsensiController::class, 'riwayat'])
    ->name('absensi.riwayat');    

});
/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/absensi', [AbsensiController::class,'index'])
        ->name('absensi.index');

    Route::post('/absensi/masuk', [AbsensiController::class,'masuk'])
        ->name('absensi.masuk');

    Route::post('/absensi/keluar', [AbsensiController::class,'keluar'])
        ->name('absensi.keluar');

});