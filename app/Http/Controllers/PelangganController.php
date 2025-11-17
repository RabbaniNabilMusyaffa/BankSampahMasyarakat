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

        // --- LOGIKA BARU UNTUK POIN EKO ---
        // Aturan: 100 poin untuk setiap 10 kg. Di bawah 10 kg = 0 poin.
        // Kita gunakan floor() untuk pembulatan ke bawah.
        $totalPoin = floor($totalBerat / 10) * 100;
        // --- AKHIR LOGIKA POIN ---

        // PERBAIKAN: Hitung jumlah setoran HARI INI (Hanya user ini)
        $jumlahSetorHariIni = TransaksiSetor::where('user_id', $userId)
            ->whereDate('created_at', $sekarang->today())
            ->count();

        // --- LOGIKA BARU UNTUK KARTU PENDAPATAN ---
        $pendapatanBulanIni = TransaksiSetor::where('user_id', $userId)
            ->whereYear('tanggal_setor', $sekarang->year)
            ->whereMonth('tanggal_setor', $sekarang->month)
            ->sum('total_harga');

        $transaksiBulanIni = TransaksiSetor::where('user_id', $userId)
            ->whereYear('tanggal_setor', $sekarang->year)
            ->whereMonth('tanggal_setor', $sekarang->month)
            ->count();
        // --- AKHIR DARI LOGIKA BARU ---

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

        // Kirim semua data ke view
        return view('page_pelanggan.home', [
            'jumlahSaldo' => $jumlahSaldo,
            'totalSetor' => $totalBerat,
            'jumlahSetor' => $jumlahSetorHariIni,
            'riwayatSetor' => $riwayatSetor,
            'riwayatTarik' => $riwayatTarik,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'transaksiBulanIni' => $transaksiBulanIni,
            'totalPoin' => $totalPoin, // <-- Data poin baru dikirim
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
        // Ambil data user yang sedang login dan kirim ke view
        $user = Auth::user();
        return view('page_pelanggan.pengaturan', compact('user'));
    }

    // --- FUNGSI BARU UNTUK MENYIMPAN PROFILE ---
    public function updatePengaturan(Request $request)
    {
        // $user = Auth::user(); // Intelephense kadang bingung dengan return type ini

        // PERBAIKAN LINTER: Ambil instance User secara eksplisit
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->back()->with('error', 'Gagal menemukan data pengguna.');
        }

        // 1. Validasi Data
        // (Pastikan nama kolom di tabel 'users' Anda sesuai, misal: 'no_telepon', 'tanggal_lahir', 'alamat')
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Cek email unik, kecuali untuk user ini
            ],
            'no_telepon' => 'nullable|string|max:15',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:500',
        ]);

        // 2. Simpan Data
        // (Gantilah 'no_telepon', 'tanggal_lahir', 'alamat' jika nama kolom di database Anda berbeda)
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->no_telepon = $request->no_telepon;
            $user->tanggal_lahir = $request->tanggal_lahir;
            $user->alamat = $request->alamat;
            $user->save();

            return redirect()->route('pengaturan')->with('success', 'Profile berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profile: ' . $e->getMessage());
        }
    }
}
