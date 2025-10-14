<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return view('page_pelanggan/home');
    }
    public function riwayat()
    {
        return view('page_pelanggan/riwayat');
    }
    public function penarikan()
    {
        return view('page_pelanggan/penarikan');
    }
    public function pengaturan()
    {
        return view('page_pelanggan/pengaturan');
    }
}
