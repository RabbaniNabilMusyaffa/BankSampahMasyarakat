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

class PelangganController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $saldoPelanggan = SaldoPelanggan::where('user_id', $userId)->first();
        $jumlahSaldo = $saldoPelanggan ? $saldoPelanggan->saldo : 0;

        // Menghitung total berat setor (Hanya user ini)
        $totalBerat = TransaksiSetor::where('user_id', $userId)->sum('total_berat');

        // PERBAIKAN: Hitung jumlah setoran HARI INI (Hanya user ini)
        $jumlahSetorHariIni = TransaksiSetor::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
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

        // PERBAIKAN LINTER: Gunakan notasi titik
        return view('page_pelanggan.home', [
            'jumlahSaldo' => $jumlahSaldo,
            'totalSetor' => $totalBerat,
            'jumlahSetor' => $jumlahSetorHariIni, // <-- Menggunakan variabel yang sudah diperbaiki
            'riwayatSetor' => $riwayatSetor,
            'riwayatTarik' => $riwayatTarik
        ]);
    }

    public function riwayat()
    {
        $userId = Auth::id();
        $riwayatSetor = TransaksiSetor::where('user_id', $userId)
            ->with(['detailSetor.kategoriSampah']) // Eager loading
            ->orderBy('tanggal_setor', 'desc')
            ->paginate(10); // Tampilkan 10 item per halaman

        // PERBAIKAN LINTER: Gunakan notasi titik
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

        // PERBAIKAN LINTER: Gunakan notasi titik
        return view('page_pelanggan.penarikan', [
            'jumlahSaldo' => $jumlahSaldo,
            'riwayatTarik' => $riwayatTarik // <-- Kirim riwayat ke view
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
                'catatan' => $request->metode, // Simpan metode (misal 'Tunai') di catatan
            ]);

            return redirect()->route('penarikan')->with('success', 'Pengajuan penarikan berhasil. Menunggu validasi petugas.');
        
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengajukan penarikan: ' . $e->getMessage());
        }
    }
    
    public function pengaturan()
    {
        // PERBAIKAN LINTER: Gunakan notasi titik
        return view('page_pelanggan.pengaturan');
    }
}