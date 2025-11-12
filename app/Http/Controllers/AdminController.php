<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KategoriSampah;
use App\Models\TransaksiSetor;
use App\Models\TransaksiTarik;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $list_user= User::where('role', 'pelanggan')->get();
        $jumlah_user=$list_user->count();
        $list_transaksi=TransaksiSetor::all()->sortBy('id');
        $jumlah_setor=$list_transaksi->count();
        $list_tarik=TransaksiTarik::all()->sortBy('id');
        $jumlah_tarik=$list_tarik->count();
        $data_transaksi=$list_transaksi->merge($list_tarik)->sortByDesc('created_at');
        $query=TransaksiSetor::with(['detailSetor.kategoriSampah']);
        $data_sampah=$query->get();
        $total_sampah=$data_sampah
        ->sum('total_berat');

        //ngitung tanggal//
        $awalBulan=Carbon::now()->startOfMonth();
        $akhirBulan=Carbon::now()->endOfMonth();

        //ngitung transaksi setiap bulan dan berat//
        $transaksiSetiapBulan=TransaksiSetor::whereBetween('tanggal_setor', [$awalBulan, $akhirBulan])->get();
        $jumlahtransaksiSetiapBulan=$transaksiSetiapBulan->count();
        $totalberatSetiapBulan=$transaksiSetiapBulan->sum('total_berat');

        //ngitung pelanggan aktif//
        $pelangganBulanIni=Carbon::now()->subDays(30);
        $jumlahPelangganAktif=TransaksiSetor::where('tanggal_setor', '>=', $pelangganBulanIni)->count();

        //ngitung total saldo//
        $totalPemasukan = TransaksiSetor::sum('total_harga');
        $totalPenarikan = TransaksiTarik::sum('jumlah');
        $totalSaldoSistem = $totalPemasukan - $totalPenarikan;

        //nunjukin laporan baru//
        $listTransaksi=TransaksiSetor::whereDate('created_at', Carbon::today())
        ->orderBy('tanggal_setor', 'desc')
        ->get();

        $listTarik=TransaksiTarik::whereDate('created_at', Carbon::today())
        ->orderBy('tanggal_request', 'desc')
        ->get();

        $listFinal=$listTransaksi->merge($listTarik)->sortByDesc('created_at');
        return view('page_admin.admin_dashboard', compact('list_user', 'jumlah_user', 'list_transaksi',
        'jumlah_setor', 'total_sampah', 'data_sampah', 'awalBulan', 'akhirBulan',
        'transaksiSetiapBulan', 'jumlahtransaksiSetiapBulan', 'totalberatSetiapBulan', 'jumlahPelangganAktif', 'pelangganBulanIni',
        'totalPemasukan', 'totalPenarikan', 'totalSaldoSistem', 'listTransaksi', 'jumlah_tarik', 'list_tarik', 'data_transaksi', 'listTarik', 'listFinal'));
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
    public function pengaturan(Request $request)
    {
        $setor = TransaksiSetor::with('user', 'petugas', 'detailSetor.kategoriSampah');
        $tarik = TransaksiTarik::with('pelanggan', 'validator');
        $total_pemasukan = TransaksiSetor::sum('total_harga');
        $total_penarikan = TransaksiTarik::sum('jumlah');
        $total_berat = $setor->sum('total_berat');
        $saldo_keseluruhan = $total_pemasukan - $total_penarikan;

        if ($request->filled('start_date') && $request->filled('end_date'))
        {
            $awalTanggal = Carbon::parse($request->start_date)->startOfDay();
            $akhirTanggal = Carbon::parse($request->end_date)->endOfDay();
            $setor->whereBetween('created_at', [$awalTanggal, $akhirTanggal]);
            $tarik->whereBetween('created_at', [$awalTanggal, $akhirTanggal]);
        }
        $setor = $setor->get();
        $tarik = $tarik->get();
        $data_laporan = $setor->merge($tarik)->sortByDesc('created_at');
        return view('page_admin.laporan', compact('setor', 'tarik', 'total_pemasukan', 'total_penarikan',
        'total_berat', 'saldo_keseluruhan', 'data_laporan', 'request'));
    }
}
