<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Pelanggan;


// Route::get('/login', function () {
//     return view('idx');
// });

Route::get('/', [App\Http\Controllers\Auth::class, 'loginIndex'])->name('login');
Route::get('/regist', [App\Http\Controllers\Auth::class, 'registerIndex'])->name('register');
Route::post('/login', [App\Http\Controllers\Auth::class, 'login'])->name('auth');
Route::get('/home', [App\Http\Controllers\Pelanggan::class, 'index'])->name('home');


