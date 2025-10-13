<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bank Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('css/pelanggan.css')}}">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        @include('navbar.navigation')

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Dashboard</h1>
                        <p class="page-subtitle">Selamat datang kembali, Budi! 👋</p>
                    </div>
                    <div class="header-date">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Senin, 13 Oktober 2025</span>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <!-- Total Setoran -->
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
                            <h3 class="stat-value">127.5 <span class="stat-unit">kg</span></h3>
                            <p class="stat-info">45 transaksi selesai</p>
                        </div>
                    </div>

                    <!-- Pendapatan Bulan Ini -->
                    <div class="stat-card stat-card-green">
                        <div class="stat-header">
                            <div class="stat-icon stat-icon-green">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="stat-badge stat-badge-success">
                                <span>↑ 8%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Pendapatan Bulan Ini</p>
                            <h3 class="stat-value">Rp 855.000<span class="stat-unit">,-</span></h3>
                            <p class="stat-info">Dari 12 transaksi</p>
                        </div>
                    </div>

                    <!-- Poin Eko -->
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
                            <h3 class="stat-value">1,250 <span class="stat-unit">Poin</span></h3>
                            <p class="stat-info">Tukar hadiah menarik! 🎁</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="transactions-grid">
                    <!-- Setoran Terakhir -->
                    <div class="transaction-card">
                        <div class="transaction-header">
                            <h3 class="transaction-title">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                Setoran Terakhir
                            </h3>
                            <a href="riwayat.blade.php" class="view-all-link">Lihat Semua →</a>
                        </div>
                        <div class="transaction-list">
                            <div class="transaction-item">
                                <div class="transaction-icon transaction-icon-green">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="transaction-details">
                                    <p class="transaction-name">Botol Plastik</p>
                                    <p class="transaction-date">10 Oktober 2025 · 15.0 kg</p>
                                </div>
                                <div class="transaction-amount transaction-amount-positive">
                                    <p>+ Rp 45.000</p>
                                    <span class="transaction-status transaction-status-success">Selesai</span>
                                </div>
                            </div>

                            <div class="transaction-item">
                                <div class="transaction-icon transaction-icon-green">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="transaction-details">
                                    <p class="transaction-name">Kardus</p>
                                    <p class="transaction-date">8 Oktober 2025 · 22.5 kg</p>
                                </div>
                                <div class="transaction-amount transaction-amount-positive">
                                    <p>+ Rp 67.500</p>
                                    <span class="transaction-status transaction-status-success">Selesai</span>
                                </div>
                            </div>

                            <div class="transaction-item">
                                <div class="transaction-icon transaction-icon-green">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="transaction-details">
                                    <p class="transaction-name">Kaleng Aluminium</p>
                                    <p class="transaction-date">5 Oktober 2025 · 8.5 kg</p>
                                </div>
                                <div class="transaction-amount transaction-amount-positive">
                                    <p>+ Rp 42.500</p>
                                    <span class="transaction-status transaction-status-success">Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penarikan Terakhir -->
                    <div class="transaction-card">
                        <div class="transaction-header">
                            <h3 class="transaction-title">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Penarikan Terakhir
                            </h3>
                            <a href="penarikan.blade.php" class="view-all-link">Lihat Semua →</a>
                        </div>
                        <div class="transaction-list">
                            <div class="transaction-item">
                                <div class="transaction-icon transaction-icon-blue">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div class="transaction-details">
                                    <p class="transaction-name">Transfer Bank BCA</p>
                                    <p class="transaction-date">9 Oktober 2025</p>
                                </div>
                                <div class="transaction-amount transaction-amount-negative">
                                    <p>- Rp 200.000</p>
                                    <span class="transaction-status transaction-status-success">Berhasil</span>
                                </div>
                            </div>

                            <div class="transaction-item">
                                <div class="transaction-icon transaction-icon-blue">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="transaction-details">
                                    <p class="transaction-name">E-Wallet GoPay</p>
                                    <p class="transaction-date">25 September 2025</p>
                                </div>
                                <div class="transaction-amount transaction-amount-negative">
                                    <p>- Rp 150.000</p>
                                    <span class="transaction-status transaction-status-success">Berhasil</span>
                                </div>
                            </div>

                            <div class="transaction-item">
                                <div class="transaction-icon transaction-icon-blue">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div class="transaction-details">
                                    <p class="transaction-name">Transfer Bank Mandiri</p>
                                    <p class="transaction-date">10 September 2025</p>
                                </div>
                                <div class="transaction-amount transaction-amount-negative">
                                    <p>- Rp 300.000</p>
                                    <span class="transaction-status transaction-status-success">Berhasil</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>