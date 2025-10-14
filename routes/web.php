<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PelangganController;

// Route::get('/login', function () {
//     return view('idx');
// });

Route::get('/', [App\Http\Controllers\AuthController::class, 'loginIndex'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth');
Route::post('/registrasi', [App\Http\Controllers\AuthController::class, 'store'])->name('registrasi');


Route::get('/regist', [App\Http\Controllers\AuthController::class, 'registrationIndex'])->name('register');

Route::middleware(['auth', 'Petugas'])->group(function () {
    Route::get('/dash', [PetugasController::class, 'index'])->name('dash_petugas');
    Route::get('/setoran', [PetugasController::class, 'setoran'])->name('petugas.input-setoran');
    Route::get('/transaksi', [PetugasController::class, 'transaksi'])->name('petugas.transaksi-harian');
    Route::get('/validasi', [PetugasController::class, 'validasi'])->name('petugas.validasi');
});

Route::middleware(['auth', 'Pelanggan'])->group(function () {
    Route::get('/home', [App\Http\Controllers\PelangganController::class, 'index'])->name('home');
    Route::get('/penarikan', [App\Http\Controllers\PelangganController::class, 'penarikan'])->name('penarikan');
    Route::get('/riwayat', [App\Http\Controllers\PelangganController::class, 'riwayat'])->name('riwayat');
    Route::get('/pengaturan', [App\Http\Controllers\PelangganController::class, 'pengaturan'])->name('pengaturan');
});
=======

