<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoPelanggan;
use App\Models\TransaksiSetor;
use App\Models\TransaksiTarik;
use App\Models\DetailTransaksiSetor;
use App\Models\KategoriSampah; // <-- Anda kekurangan ini di file asli, tambahkan

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User; // <-- Pastikan ini ada
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $sekarang = Carbon::now();

        $saldoPelanggan = SaldoPelanggan::where('user_id', $userId)->first();
        $jumlahSaldo = $saldoPelanggan ? $saldoPelanggan->saldo : 0;

        // Menghitung total berat setor (Hanya user ini)
        $totalBerat = TransaksiSetor::where('user_id', $userId)->sum('total_berat');
        $totalPoin = floor($totalBerat / 10) * 100;-

        // Hitung jumlah setoran HARI INI (Hanya user ini)
        $jumlahSetorHariIni = TransaksiSetor::where('user_id', $userId)
            ->whereDate('created_at', $sekarang->today())
            ->count();


        $pendapatanBulanIni = TransaksiSetor::where('user_id', $userId)
            ->whereYear('tanggal_setor', $sekarang->year)
            ->whereMonth('tanggal_setor', $sekarang->month)
            ->sum('total_harga');

        $transaksiBulanIni = TransaksiSetor::where('user_id', $userId)
            ->whereYear('tanggal_setor', $sekarang->year)
            ->whereMonth('tanggal_setor', $sekarang->month)
            ->count();


        // Ambil 3 riwayat setor terakhir (Hanya user ini)
        $riwayatSetor = TransaksiSetor::where('user_id', $userId)
            ->with(['detailSetor.kategoriSampah'])
            ->orderBy('tanggal_setor', 'desc')
            ->take(3)
            ->get();

        // Ambil 3 riwayat tarik terakhir (Hanya user ini)
        $riwayatTarik = TransaksiTarik::where('user_id', $userId)
            ->orderBy('tanggal_request', 'desc')
            ->take(3)
            ->get();


        return view('page_pelanggan.home', [
            'jumlahSaldo' => $jumlahSaldo,
            'totalSetor' => $totalBerat,
            'jumlahSetor' => $jumlahSetorHariIni,
            'riwayatSetor' => $riwayatSetor,
            'riwayatTarik' => $riwayatTarik,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'transaksiBulanIni' => $transaksiBulanIni,
            'totalPoin' => $totalPoin,
        ]);
    }

    public function riwayat()
    {
        $userId = Auth::id();
        $riwayatSetor = TransaksiSetor::where('user_id', $userId)
            ->with(['detailSetor.kategoriSampah'])
            ->orderBy('tanggal_setor', 'desc')
            ->paginate(10);


        return view('page_pelanggan.riwayat', [
            'riwayatSetor' => $riwayatSetor
        ]);
    }

    public function penarikan()
    {
        $userId = Auth::id();
        $saldoPelanggan = SaldoPelanggan::where('user_id', $userId)->first();
        $jumlahSaldo = $saldoPelanggan ? $saldoPelanggan->saldo : 0;
        $riwayatTarik = TransaksiTarik::where('user_id', $userId)
            ->orderBy('tanggal_request', 'desc')
            ->take(5) // Ambil 5 terbaru
            ->get();


        return view('page_pelanggan.penarikan', [
            'jumlahSaldo' => $jumlahSaldo,
            'riwayatTarik' => $riwayatTarik
        ]);
    }

    public function ajukanPenarikan(Request $request)
    {
        $userId = Auth::id();
        $saldoPelanggan = SaldoPelanggan::where('user_id', $userId)->first();
        $saldoSaatIni = $saldoPelanggan ? $saldoPelanggan->saldo : 0;

        $request->validate([
            'jumlah' => 'required|numeric|min:50000|max:' . $saldoSaatIni,
            'metode' => 'required|string',
        ], [
            'jumlah.max' => 'Saldo Anda tidak mencukupi untuk penarikan ini.',
            'jumlah.min' => 'Minimum penarikan adalah Rp 50.000.',
        ]);

        try {
            TransaksiTarik::create([
                'user_id' => $userId,
                'kode_transaksi' => TransaksiTarik::generateKodeTransaksi(),
                'tanggal_request' => Carbon::now(),
                'jumlah' => $request->jumlah,
                'status' => 'pending',
                'catatan' => $request->metode,
            ]);

            return redirect()->route('penarikan')->with('success', 'Pengajuan penarikan berhasil. Menunggu validasi petugas.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengajukan penarikan: ' . $e->getMessage());
        }
    }

    public function pengaturan()
    {

        $user = Auth::user();
        return view('page_pelanggan.pengaturan', compact('user'));
    }

    
    public function updatePengaturan(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'date' => 'nullable',
            'address' => 'nullable',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->date = $request->date;
        $user->address = $request->address;
        $user->save();
        return redirect()->route('pengaturan')->with('success', 'Profile berhasil diperbarui.');
    }
}
