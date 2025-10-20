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
  title: "Hayoooo",
  text: "Aksesmu ngga sah lohhh",
  showConfirmButton: false,
                timer: 1500
                                
});
                        </script>
                        </ul>
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
            <div class="activity-icon">✓</div>
            <div class="activity-content">
                <h3>Transaksi Setoran</h3>
                <p>Anda telah memproses <strong>{{ $jumlahSetoran ?? 0 }} transaksi setoran</strong> dengan total sampah <strong>{{ $beratSetoran ?? 0 }} kg</strong>.</p>
            </div>
        </div>

        <div class="activity-card warning">
            <div class="activity-icon">⏰</div>
            <div class="activity-content">
                <h3>Request Penarikan</h3>
                <p>Terdapat <strong>{{ $requestPenarikan ?? 0 }} request penarikan saldo</strong> yang menunggu validasi Anda.</p>
            </div>
        </div>

        <div class="activity-card info">
            <div class="activity-icon">📈</div>
            <div class="activity-content">
                <h3>Performa Hari Ini</h3>
                <p>Aktivitas meningkat <strong>{{ $persentaseNaik ?? 0 }}%</strong> dibandingkan hari kemarin dengan total pendapatan <strong>Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</strong>.</p>
            </div>
        </div>
    </div>

    
@endsection