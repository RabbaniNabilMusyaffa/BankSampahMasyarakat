<?php

use Illuminate\Support\Facades\Route;


// Route::get('/login', function () {
//     return view('idx');
// });

Route::get('/', [App\Http\Controllers\Auth::class, 'index'])->name('login');