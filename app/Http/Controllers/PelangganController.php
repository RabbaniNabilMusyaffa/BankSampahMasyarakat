<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'foto_profil'=> 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->filled('date')) {
            $user->date = $request->date;
        }

        if ($request->filled('address')) {
            $user->address = $request->address;
        }

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $user->foto_profil = $path;
        }

        $user->save();
        return redirect()->route('pengaturan')->with('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        if(!Hash::check($request->passwordSekarang, auth()->user()->password)) {
            return back()->with('error', 'Password lama tidak cocok');
        }
        if($request->passwordBaru != $request->konfirmasiPassword) {
            return back()->with('error', 'Password baru dan konfirmasi password tidak cocok');
        }
        auth()->user()->update([
            'password'=> Hash::make($request->passwordBaru)
        ]);

        return back()->with('success', 'Password berhasil diperbarui');
    }

    public function updateNotifikasi(Request $request)
    {
    $user = Auth::user();
    // Update kolom di database
    $user->notif_penarikan = $request->notif_penarikan;
    $user->save();

    return response()->json(['success' => true]);
    }
}
