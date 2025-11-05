<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('page_admin.admin_dashboard');
    }
    public function riwayat()
    {
        return view('page_admin.kategori_sampah');
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
        return view('page_admin.laporan');
    }
}
