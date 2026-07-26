<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SettingLokasiController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\ApprovalController;

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

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

    /*
    |--------------------------------------------------------------------------
    | Approval Pengajuan Izin
    |--------------------------------------------------------------------------
    */

    Route::get('/approval', [ApprovalController::class, 'index'])
        ->name('approval.index');

    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])
        ->name('approval.approve');

    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])
        ->name('approval.reject');
});

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Absensi
    |--------------------------------------------------------------------------
    */

    Route::get('/absensi', [AbsensiController::class, 'index'])
        ->name('absensi.index');

    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])
        ->name('absensi.masuk');

    Route::post('/absensi/keluar', [AbsensiController::class, 'keluar'])
        ->name('absensi.keluar');

    /*
    |--------------------------------------------------------------------------
    | Pengajuan Izin
    |--------------------------------------------------------------------------
    */

    Route::get('/izin', [PengajuanIzinController::class, 'index'])
        ->name('izin.index');

    Route::get('/izin/create', [PengajuanIzinController::class, 'create'])
        ->name('izin.create');

    Route::post('/izin', [PengajuanIzinController::class, 'store'])
        ->name('izin.store');
});