<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('page_admin/admin_dashboard');
    }
    public function riwayat()
    {
        return view('page_admin/kategori_sampah');
    }
    public function penarikan()
    {
        return view('page_admin/kelola_user');
    }
    public function pengaturan()
    {
        return view('page_admin/laporan');
    }
}
