<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Petugas extends Controller
{
    public function index(){
        return view('page_petugas/dashboard');
    }
}
