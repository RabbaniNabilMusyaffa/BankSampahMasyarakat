<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiSetor;
use App\Models\DetailTransaksiSetor;
use App\Models\KategoriSampah;
use App\Models\User;

// --- TAMBAHKAN INI ---
use Illuminate\Support\Facades\DB;   // Untuk database transaction
use Illuminate\Support\Facades\Auth;  // Untuk mengambil ID petugas yg login
use Carbon\Carbon;                    // Untuk manajemen tanggal
// --------------------


class PetugasController extends Controller
{
    // ... fungsi index() dan setoran() Anda biarkan saja ...
    public function index()
    {
        return view('page_petugas/dashboard');
    }
    public function setoran()
    {
        $pelanggans=User::where('role', 'pelanggan')->get();
        $kategoris=KategoriSampah::all();
        $setorans = TransaksiSetor::whereDate('created_at', today())->get();
        return view('page_petugas/input_setoran', [
            'pelanggans' => $pelanggans,
            'kategoris' => $kategoris,
            'setorans' => $setorans
        ]);
    }


    // --- GANTI FUNGSI INI ---
    public function setor(Request $request)
    {
        // 1. Validasi (tambahkan validasi yang lebih baik)
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'berat' => 'required|numeric|min:0.1', // Asumsi berat minimal 0.1
            'subtotal' => 'required|numeric|min:0',
            'catatan' => 'nullable|string', // Catatan boleh kosong
        ]);

        // 2. Mulai Database Transaction
        DB::beginTransaction();

        try {
            // 3. SIMPAN KE TABEL HEADER (transaksi_setor)
            $transaksi = new TransaksiSetor();
            $transaksi->user_id = $request->user_id;         // ID Pelanggan
            $transaksi->petugas_id = Auth::id();           // ID Petugas (asumsi Anda pakai Auth)
            $transaksi->tanggal_setor = Carbon::now();
            $transaksi->kode_transaksi = 'SETOR-' . date('YmdHis'); // Contoh kode unik sederhana

            // Karena ini item pertama, total = subtotal
            $transaksi->total_berat = $request->berat;
            $transaksi->total_harga = $request->subtotal;
            $transaksi->catatan = $request->catatan;

            $transaksi->save(); // Simpan ke tabel 'transaksi_setor'

            // 4. SIMPAN KE TABEL DETAIL (detail_transaksi_setor)
            $detail = new DetailTransaksiSetor();
            $detail->transaksi_setor_id = $transaksi->id; // <-- PENTING: Ambil ID dari header
            $detail->kategori_sampah_id = $request->kategori_sampah_id;
            $detail->berat = $request->berat;
            $detail->subtotal = $request->subtotal;

            // Hitung harga_per_kg dari input (jika kolomnya ada)
            if ($request->berat > 0) {
                $detail->harga_per_kg = $request->subtotal / $request->berat;
            } else {
                $detail->harga_per_kg = 0;
            }

            $detail->save(); // Simpan ke tabel 'detail_transaksi_setor'

            // 5. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route('petugas.input-setoran')->with('success', 'Penambahan setoran berhasil.');

        } catch (\Exception $e) {
            // 6. Jika ada error, batalkan semua (rollback)
            DB::rollback();

            // Tampilkan error (lebih baik di-log)
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    // -------------------------


    public function transaksi()
    {
        return view('page_petugas/transaksi_harian');
    }
    public function validasi()
    {
        return view('page_petugas/validasi');
    }
}