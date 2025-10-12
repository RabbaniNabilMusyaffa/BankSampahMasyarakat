<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Petugas;

// Route::get('/login', function () {
//     return view('idx');
// });

Route::get('/', [App\Http\Controllers\Auth::class, 'loginIndex'])->name('login');
Route::get('/regist',[App\Http\Controllers\Auth::class, 'registrationIndex'])->name('register');
Route::get('/dash', [App\Http\Controllers\Petugas::class, 'index'])->name('dash_petugas');
Route::post('/login', [App\Http\Controllers\Auth::class, 'login'])->name('auth');
Route::get('/home', [App\Http\Controllers\Pelanggan::class, 'index'])->name('home');