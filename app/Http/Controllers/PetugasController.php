<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // <-- Ini untuk $request
use App\Models\TransaksiSetor;
use App\Models\TransaksiTarik;
use App\Models\DetailTransaksiSetor;
use App\Models\KategoriSampah;
use App\Models\User;
use App\Models\SaldoPelanggan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PetugasController extends Controller
{
    // ... fungsi index() dan setoran() Anda biarkan saja ...
    public function index()
    {
        $today = Carbon::today();
        $petugasId = Auth::id(); // Mengambil ID petugas yang sedang login

        // --- 1. Data untuk Stat Cards (Bagian Atas) ---

        // Card 1: Transaksi Hari Ini (Setoran)
        $transaksiSetorHariIni = TransaksiSetor::whereDate('created_at', $today)->get();
        $jumlah_setor = $transaksiSetorHariIni->count();

        // Card 2: Sampah Terkumpul (Hari Ini)
        $total_sampah = $transaksiSetorHariIni->sum('total_berat');

        // Card 3: Request Penarikan (Semua yang masih 'pending')
        $totalPenarikan = TransaksiTarik::where('status', 'pending')->count();

        // --- 2. Data untuk "Aktivitas Hari Ini" ---

        // Aktivitas 1: Setoran Terakhir Hari Ini
        $setoran = TransaksiSetor::with(['user', 'detailSetor.kategoriSampah'])
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc') // Ambil yang paling baru
            ->first();

        $setoranTerakhir = null;
        if ($setoran) {
            // Buat objek kustom agar sesuai dengan view
            $setoranTerakhir = (object) [
                'waktu' => $setoran->created_at->format('H:i'),
                'nama_nasabah' => $setoran->user->name ?? 'N/A', // Ganti 'nama' menjadi 'name'
                'kategori' => $setoran->detailSetor->first()->kategoriSampah->nama_kategori ?? 'sampah',
                'berat' => $setoran->total_berat
            ];
        }

        // Aktivitas 2: Penarikan Terakhir Hari Ini (Request Terbaru)
        $penarikan = TransaksiTarik::with('pelanggan')
            ->whereDate('tanggal_request', $today) // Berdasarkan kapan di-request
            ->orderBy('tanggal_request', 'desc')
            ->first();

        $penarikanTerakhir = null;
        if ($penarikan) {
            // Buat objek kustom agar sesuai dengan view
            $penarikanTerakhir = (object) [
                'waktu' => $penarikan->created_at->format('H:i'),
                'nama_nasabah' => $penarikan->pelanggan->name ?? 'N/A', // Ganti 'nama' menjadi 'name'
                'jumlah' => $penarikan->jumlah,
                'status' => ucfirst($penarikan->status) // misal: 'Pending'
            ];
        }

        // Aktivitas 3: Status Validasi (Yang divalidasi oleh PETUGAS INI, HARI INI)
        $validasiHariIni = TransaksiTarik::where('petugas_id', $petugasId)
            ->whereDate('tanggal_validasi', $today) // Berdasarkan kapan divalidasi
            ->get();

        $totalValidasi = $validasiHariIni->count();
        $totalDisetujui = $validasiHariIni->where('status', 'approved')->count();
        $totalDitolak = $validasiHariIni->where('status', 'rejected')->count();

        // --- 3. Kirim semua data ke View ---
        return view('page_petugas.dashboard', compact(
            'jumlah_setor',
            'total_sampah',
            'totalPenarikan',
            'setoranTerakhir',
            'penarikanTerakhir',
            'totalValidasi',
            'totalDisetujui',
            'totalDitolak'
        ));
    }
    public function setoran()
    {
        $pelanggans = User::where('role', 'pelanggan')->get();
        $kategoris = KategoriSampah::all();
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
            $transaksi->user_id = $request->user_id;        // ID Pelanggan
            $transaksi->petugas_id = Auth::id();           // ID Petugas
            $transaksi->tanggal_setor = Carbon::now();

            // Gunakan generator kode dari model jika ada
            $transaksi->kode_transaksi = TransaksiSetor::generateKodeTransaksi();

            $transaksi->total_berat = $request->berat;
            $transaksi->total_harga = $request->subtotal;
            $transaksi->catatan = $request->catatan;
            $transaksi->save(); // Simpan ke tabel 'transaksi_setor'

            // 4. SIMPAN KE TABEL DETAIL (detail_transaksi_setor)
            $detail = new DetailTransaksiSetor();
            $detail->transaksi_setor_id = $transaksi->id; // <-- PENTING
            $detail->kategori_sampah_id = $request->kategori_sampah_id;
            $detail->berat = $request->berat;
            $detail->subtotal = $request->subtotal;

            if ($request->berat > 0) {
                $detail->harga_per_kg = $request->subtotal / $request->berat;
            } else {
                $detail->harga_per_kg = 0;
            }
            $detail->save(); // Simpan ke tabel 'detail_transaksi_setor'

            // 5. UPDATE SALDO PELANGGAN (INI BAGIAN TAMBAHANNYA)
            // Cari saldo pelanggan, atau buat baru jika tidak ada
            $saldoPelanggan = SaldoPelanggan::firstOrCreate(
                ['user_id' => $request->user_id],
                ['saldo' => 0, 'total_setor' => 0, 'total_tarik' => 0] // Nilai default jika baru dibuat
            );

            // Panggil method helper dari model SaldoPelanggan
            $saldoPelanggan->tambahSaldo($request->subtotal);

            // 6. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route('petugas.input-setoran')->with('success', 'Penambahan setoran berhasil.');
        } catch (\Exception $e) {
            // 7. Jika ada error, batalkan semua (rollback)
            DB::rollback();

            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    // -------------------------


    public function transaksi()
    {
        $today = Carbon::today();

        // 1. Ambil Setoran Hari Ini
        $setoran = TransaksiSetor::with(['user', 'petugas', 'detailSetor.kategoriSampah'])
            ->whereDate('created_at', $today)
            ->get();

        // 2. Ambil Penarikan yang Disetujui Hari Ini
        // Kita ambil yang 'approved' karena itu transaksi yang "terjadi"
        $penarikan = TransaksiTarik::with(['pelanggan', 'validator'])
            ->where('status', 'approved')
            ->whereDate('tanggal_validasi', $today) // <- Pakai tanggal_validasi
            ->get();

        // 3. Tambahkan properti kustom untuk standarisasi
        $setoran->each(function ($item) {
            $item->jenis_transaksi = 'setoran';
            $item->waktu = $item->created_at;
            $item->pelanggan_data = $item->user;     // Standarisasi relasi pelanggan
            $item->petugas_data = $item->petugas;    // Standarisasi relasi petugas
            $item->nominal = $item->total_harga;
        });

        $penarikan->each(function ($item) {
            $item->jenis_transaksi = 'penarikan';
            $item->waktu = $item->tanggal_validasi; // Pakai tanggal_validasi sebagai waktu
            $item->pelanggan_data = $item->pelanggan;
            $item->petugas_data = $item->validator;
            $item->nominal = $item->jumlah;
        });

        // 4. Gabungkan kedua collection dan urutkan berdasarkan waktu
        $transaksis = $setoran->merge($penarikan)->sortByDesc('waktu');

        // 5. Hitung total untuk summary cards
        $totalSetoran = $setoran->sum('nominal');
        $totalPenarikan = $penarikan->sum('nominal');
        $jumlahSetoran = $setoran->count();
        $jumlahPenarikan = $penarikan->count();
        $totalNominal = $totalSetoran - $totalPenarikan; // Total uang kas masuk/keluar

        return view('page_petugas/transaksi_harian', compact(
            'transaksis',
            'totalSetoran',
            'totalPenarikan',
            'jumlahSetoran',
            'jumlahPenarikan',
            'totalNominal'
        ));
    }
    public function validasi()
    {

        $penarikanPending = TransaksiTarik::where('status', 'pending')
            ->with('pelanggan') // Eager load relasi pelanggan
            ->orderBy('tanggal_request', 'asc')
            ->get();
        $riwayatValidasi = TransaksiTarik::whereIn('status', ['approved', 'rejected'])
            ->with(['pelanggan', 'validator']) // Eager load pelanggan & validator
            ->orderBy('tanggal_validasi', 'desc')
            ->paginate(10); // Pakai pagination untuk riwayat

        return view('page_petugas/validasi', compact('penarikanPending', 'riwayatValidasi'));
    }

    public function approvePenarikan(Request $request, $id)
    {
        // Gunakan DB Transaction untuk memastikan saldo dan status aman
        DB::beginTransaction();
        try {
            $transaksi = TransaksiTarik::findOrFail($id);
            if ($transaksi->status != 'pending') {
                return redirect()->back()->with('error', 'Transaksi ini sudah tidak pending.');
            }
            $saldoPelanggan = SaldoPelanggan::where('user_id', $transaksi->user_id)->first();
            if (!$saldoPelanggan) {
                throw new \Exception('Data saldo pelanggan tidak ditemukan.');
            }

            // 3. Kurangi saldo menggunakan helper
            $berhasilKurangi = $saldoPelanggan->kurangiSaldo($transaksi->jumlah);
            if (!$berhasilKurangi) {
                throw new \Exception('Saldo pelanggan tidak mencukupi.');
            }

            // 4. Update status transaksi
            $transaksi->status = 'approved';
            $transaksi->petugas_id = Auth::id(); // Catat siapa yang memvalidasi
            $transaksi->tanggal_validasi = Carbon::now();
            $transaksi->save();

            // 5. Jika semua berhasil, commit
            DB::commit();

            return redirect()->route('petugas.validasi')->with('success', 'Penarikan berhasil disetujui.');
        } catch (\Exception $e) {
            // 6. Jika ada error, batalkan semua
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    public function rejectPenarikan(Request $request, $id)
    {
        // Validasi alasan (wajib diisi)
        $request->validate(['alasan_penolakan' => 'required|string|min:5']);

        try {
            $transaksi = TransaksiTarik::findOrFail($id);

            if ($transaksi->status != 'pending') {
                return redirect()->back()->with('error', 'Transaksi ini sudah tidak pending.');
            }

            // Update status transaksi
            $transaksi->status = 'rejected';
            $transaksi->petugas_id = Auth::id();
            $transaksi->tanggal_validasi = Carbon::now();
            $transaksi->alasan_penolakan = $request->alasan_penolakan;
            $transaksi->save();

            // Tidak perlu DB Transaction karena tidak mengubah saldo

            return redirect()->route('petugas.validasi')->with('success', 'Penarikan telah ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak: ' . $e->getMessage());
        }
    }
}
