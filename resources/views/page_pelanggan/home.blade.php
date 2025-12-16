<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bank Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('css/pelanggan.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
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
    <div class="app-container">
        {{-- sidebar --}}
        @include('navbar.nav-pelanggan')

        {{-- konten --}}
        <main class="main-content">
            <div class="content-wrapper">

                <div class="page-header">
                    <div>
                        <h1 class="page-title">Dashboard</h1>
                        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name ?? 'Budi Santoso' }}! </p>
                    </div>
                    <div class="header-date">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Senin, 13 Oktober 2025</span>
                    </div>
                </div>

                {{-- cards --}}

{{-- KARTU "SALDO TERKINI" --}}
<div class="saldo-utama-card">
    <div class="saldo-utama-content">
        <p class="saldo-utama-label">Saldo Terkini Anda</p>

        <h2 class="saldo-utama-value">Rp {{ number_format($jumlahSaldo ?? 0, 0, ',', '.') }}</h2>
    </div>
    <div class="saldo-utama-icon">

         <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
    </div>
</div>
{{-- end card saldo --}}

                <div class="stats-grid">
                    {{-- total setoran --}}
                    <div class="stat-card stat-card-blue">
                        <div class="stat-header">
                            <div class="stat-icon stat-icon-blue">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="stat-badge stat-badge-success">
                                <span>↑ 12%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Total Setoran</p>
                            <h3 class="stat-value">{{ $totalSetor }} <span class="stat-unit">kg</span></h3>
                            <p class="stat-info">{{ $jumlahSetor }} <span class="stat-info">transaksi selesai</span></p>
                        </div>
                    </div>

                    {{-- pendapatan bulanan --}}
                    <div class="stat-card stat-card-green">
                        <div class="stat-header">
                            <div class="stat-icon stat-icon-green">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <div class="stat-content">
                            <p class="stat-label">Pendapatan Bulan Ini</p>
                            <h3 class="stat-value">Rp {{ $pendapatanBulanIni }}<span class="stat-unit">,-</span></h3>
                            <p class="stat-info">Dari {{$jumlahSetor }} transaksi</p>
                        </div>
                    </div>

                    {{-- poin bank sam --}}
                    <div class="stat-card stat-card-gold">
                        <div class="stat-header">
                            <div class="stat-icon stat-icon-gold">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Poin Eko Anda</p>
                            <h3 class="stat-value">{{ $totalPoin }} <span class="stat-unit">Poin</span></h3>
                            <p class="stat-info">Tukar hadiah menarik!</p>
                        </div>
                    </div>
                </div>

                {{-- transaksi --}}
                <div class="transactions-grid">
                    {{-- setoran --}}
                    <div class="transaction-card card-base">
                        <div class="transaction-header">
                            <h3 class="transaction-title">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                Setoran Terakhir
                            </h3>
                            <a href="{{ route('riwayat') }}" class="view-all-link">Lihat Semua →</a>
                        </div>
                        <div class="transaction-list">
    @forelse($riwayatSetor as $setoran)
        <div class="transaction-item">
            <div class="transaction-icon transaction-icon-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="transaction-details">
                {{-- Mengambil nama kategori dari detail setoran pertama --}}
                <p class="transaction-name">{{ $setoran->detailSetor->first()->kategoriSampah->nama_kategori ?? 'N/A' }}</p>
                <p class="transaction-date">
                    {{ \Carbon\Carbon::parse($setoran->tanggal_setor)->format('d F Y') }}
                    ·
                    {{ number_format($setoran->total_berat, 1, '.', ',') }} kg
                    {{-- Menggunakan titik sebagai pemisah desimal sesuai gambar --}}
                </p>
            </div>
            <div class="transaction-amount transaction-amount-positive">
                <p>+ Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</p>
                <span class="transaction-status transaction-status-success">Selesai</span>
            </div>
        </div>
    @empty
        {{-- Pesan ini akan tampil jika tidak ada riwayat setoran --}}
        <div class="p-4 text-center text-gray-500">Belum ada riwayat setoran sampah.</div>
    @endforelse
</div>
                    </div>

                    {{-- penarikan --}}
<div class="transaction-card card-base">
    <div class="transaction-header">
        <h3 class="transaction-title">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {{-- ... (icon svg Anda) ... --}}
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Penarikan Terakhir
        </h3>
        {{-- PERBAIKAN: Gunakan route() untuk link --}}
        <a href="{{ route('penarikan') }}" class="view-all-link">Lihat Semua →</a>
    </div>
    <div class="transaction-list">

        {{-- Ganti data statis dengan loop @forelse --}}
        @forelse($riwayatTarik ?? [] as $tarik)
            <div class="transaction-item">
                <div class="transaction-icon transaction-icon-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="transaction-details">
                    {{-- Tampilkan metode (dari 'catatan') jika ada --}}
                    <p class="transaction-name">Penarikan {{ $tarik->catatan ?? 'Tunai' }}</p>
                    <p class="transaction-date">{{ \Carbon\Carbon::parse($tarik->tanggal_request)->format('d F Y') }}</p>
                </div>
                <div class="transaction-amount transaction-amount-negative">
                    <p>- Rp {{ number_format($tarik->jumlah, 0, ',', '.') }}</p>

                    {{-- Tampilkan status dinamis --}}
                    @if($tarik->status == 'approved')
                        <span class="transaction-status transaction-status-success">Berhasil</span>
                    @elseif($tarik->status == 'rejected')
                        {{-- Sesuaikan class CSS Anda jika perlu --}}
                        <span class="transaction-status transaction-status-danger" style="background-color: #fee2e2; color: #dc2626;">Ditolak</span>
                    @else
                        {{-- Sesuaikan class CSS Anda jika perlu --}}
                        <span class="transaction-status transaction-status-warning" style="background-color: #fffbeb; color: #f59e0b;">Pending</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="transaction-item" style="justify-content: center;">
                <p style="color: #718096;">Belum ada riwayat penarikan.</p>
            </div>
        @endforelse
    </div>
</div></div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('javascript/pelanggan.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfigurasi Toast ala WhatsApp (Muncul di atas, hilang sendiri)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end', // Muncul di pojok kanan atas
        showConfirmButton: false,
        timer: 4000, // Muncul selama 4 detik
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>

{{-- Cek apakah ada Notifikasi Database yang belum dibaca --}}
@if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
    @foreach(auth()->user()->unreadNotifications as $notification)
        <script>
            Toast.fire({
                icon: '{{ $notification->data['status'] }}', // icon success atau error
                title: 'Notifikasi Baru',
                text: '{{ $notification->data['pesan'] }}'
            });
        </script>

        {{-- Tandai notifikasi sebagai sudah dibaca agar tidak muncul terus --}}
        @php $notification->markAsRead(); @endphp
    @endforeach
@endif

</body>
</html>
