<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PelangganController;

// Route::get('/login', function () {
//     return view('idx');
// });

Route::get('/', [App\Http\Controllers\AuthController::class, 'loginIndex'])->name('login');
Route::get('/regist', [App\Http\Controllers\AuthController::class, 'registrationIndex'])->name('register');
Route::get('/dash', [App\Http\Controllers\PetugasController::class, 'index'])->name('dash_petugas');
Route::get('/setoran', [App\Http\Controllers\PetugasController::class, 'setoran'])->name('petugas.input-setoran');
Route::get('/transaksi', [App\Http\Controllers\PetugasController::class, 'transaksi'])->name('petugas.transaksi-harian');
Route::get('/validasi', [App\Http\Controllers\PetugasController::class, 'validasi'])->name('petugas.validasi');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth');
Route::post('/registrasi', [App\Http\Controllers\AuthController::class, 'store'])->name('registrasi');
Route::get('/home', [App\Http\Controllers\PelangganController::class, 'index'])->name('home');

