@extends('layouts.app')

@section('title', 'Dashboard - Bank Sampah')

@section('page-title', 'Dashboard Bank Sampah')

@section('content')
{{-- @if (session('success'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('success') }}", // Ambil pesan dari session
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif --}}
     <div class="card-body p-0">
        @if (count($errors) > 0)
        <script>
            Swal.fire({
            icon: "error",
            title: "Peringatan",
            text: "{{$errors->first()}}",
            showConfirmButton: false,
            timer: 1500
            });
        </script>
    </div>
        @endif
    
    <!-- Alert Selamat Datang -->
    <div class="alert alert-success">
        <span>Selamat datang, <strong>{{ auth()->user()->name ?? 'Budi Santoso' }}</strong>! Anda login sebagai Petugas Bank Sampah.</span>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Transaksi Hari Ini</div>
                    <div class="stat-value">{{ $totalTransaksi ?? 0 }}</div>
                    <div class="stat-label">Total transaksi</div>
                </div>
                <div class="stat-icon">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
            <rect x="6" y="18" width="5" height="10" rx="1" fill="#4299e1"/>
            <rect x="13.5" y="12" width="5" height="16" rx="1" fill="#48bb78"/>
            <rect x="21" y="6" width="5" height="22" rx="1" fill="#ed8936"/>
    </svg>
</div>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Sampah Terkumpul</div>
                    <div class="stat-value">{{ $totalSampah ?? 0 }}</div>
                    <div class="stat-label">Kilogram (Kg)</div>
                </div>
                <div class="stat-icon">♻️</div>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Request Penarikan</div>
                    <div class="stat-value">{{ $totalPenarikan ?? 0 }}</div>
                    <div class="stat-label">Menunggu validasi</div>
                </div>
              <div class="stat-icon">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Frame Atas -->
        <rect x="8" y="4" width="16" height="3" rx="1" fill="#805ad5"/>
        <!-- Bagian Atas Hourglass -->
        <path d="M9 7 L16 16 L23 7 Z" fill="#9f7aea"/>
        <!-- Bagian Bawah Hourglass -->
        <path d="M9 25 L16 16 L23 25 Z" fill="#b794f4"/>
        <!-- Frame Bawah -->
        <rect x="8" y="25" width="16" height="3" rx="1" fill="#805ad5"/>
        <!-- Pasir Jatuh -->
        <circle cx="16" cy="20" r="2" fill="#d6bcfa"/>
        <circle cx="16" cy="23" r="1.5" fill="#d6bcfa"/>
    </svg>
</div>
            </div>
        </div>
    </div>

        <!-- Aktivitas Hari Ini -->
        <div class="content-box">
            <h2>📊 Aktivitas Hari Ini</h2>
            
            <div class="activity-card success">
                <div class="activity-icon">📄</div>
                <div class="activity-content">
                    <h3>Setoran Terakhir</h3>
                    <p>Pukul <strong>{{ $setoranTerakhir->waktu ?? '-' }}</strong> - <strong>{{ $setoranTerakhir->nama_nasabah ?? '-' }}</strong> menyetor {{ $setoranTerakhir->kategori ?? '-' }} seberat <strong>{{ $setoranTerakhir->berat ?? 0 }} kg</strong></p>
                </div>
            </div>

            <div class="activity-card warning">
                <div class="activity-icon">💵</div>
                <div class="activity-content">
                    <h3>Penarikan Terakhir</h3>
                    <p>Pukul <strong>{{ $penarikanTerakhir->waktu ?? '-' }}</strong> - Request penarikan dari <strong>{{ $penarikanTerakhir->nama_nasabah ?? '-' }}</strong> sebesar <strong>Rp {{ number_format($penarikanTerakhir->jumlah ?? 0, 0, ',', '.') }}</strong> - <strong>{{ $penarikanTerakhir->status ?? 'Menunggu Validasi' }}</strong></p>
                </div>
            </div>

            <div class="activity-card info">
                <div class="activity-icon">✅</div>
                <div class="activity-content">
                    <h3>Status Validasi</h3>
                    <p>Hari ini Anda sudah memvalidasi <strong>{{ $totalValidasi ?? 0 }} transaksi</strong> dengan total <strong>{{ $totalDisetujui ?? 0 }} disetujui</strong> dan <strong>{{ $totalDitolak ?? 0 }} ditolak</strong>.</p>
                </div>
            </div>
        </div>

    
@endsection

{{-- @push('scripts')
<script>
    // Periksa jika ada session 'success' dari controller
    @if (session('success'))
        // Jika ada, panggil fungsi toastr.succes
        
        toastr.success("{{ session('success') }}");
    @endif

</script>
@endpush --}}