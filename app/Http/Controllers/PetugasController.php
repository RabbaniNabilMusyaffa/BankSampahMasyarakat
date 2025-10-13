<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        return view('page_petugas/dashboard');
    }
    public function setoran()
    {
        return view('page_petugas/input_setoran');
    }
    public function transaksi()
    {
        return view('page_petugas/transaksi_harian');
    }
    public function validasi()
    {
        return view('page_petugas/validasi');
    }
}
