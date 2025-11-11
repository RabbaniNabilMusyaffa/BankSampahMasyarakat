<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KategoriSampah;
use App\Models\TransaksiSetor;

class AdminController extends Controller
{
    public function index()
    {
        return view('page_admin.admin_dashboard');
    }
    public function riwayat()
    {
        $data_sampah=KategoriSampah::all();
        return view('page_admin.kategori_sampah',compact('data_sampah'));
    }

    public function kategoriTambah(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'harga_per_kg' => 'required',
            'deskripsi' => 'required',
        ]);

        $user = new \App\Models\KategoriSampah();
        $user->nama_kategori = $request->nama_kategori;
        $user->harga_per_kg = $request->harga_per_kg;
        $user->deskripsi = $request->deskripsi;
        $user->save();

        return redirect()->route('admin.kategori')->with('success', 'Penambahan kategori berhasil.');
    }
    public function penarikan()
    {
        $data_user=User::all();
        return view('page_admin.kelola_user',compact('data_user'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);

        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('admin.kelola')->with('success', 'Penambahan user berhasil.');
    }
    public function pengaturan()
    {
        $data_setor=TransaksiSetor::all();
        return view('page_admin.laporan', compact('data_setor'));
    }
}
