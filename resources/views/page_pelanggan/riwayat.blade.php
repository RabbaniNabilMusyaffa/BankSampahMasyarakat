<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Setoran - Bank Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('css/pelanggan.css')}}">
</head>
<body>
    <div class="app-container">
        @include('navbar.navigation')

        <main class="main-content">
            <div class="content-wrapper">
                <div class="page-header">
                    <h1 class="page-title">Riwayat Setoran</h1>
                    <p class="page-subtitle">Lihat semua transaksi setoran sampah Anda</p>
                </div>

                <!-- Search & Filter -->
                <div class="search-filter-container">
                    <div class="search-box">
                        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Cari jenis sampah..." class="search-input">
                    </div>
                    <select class="filter-select">
                        <option>Semua Status</option>
                        <option>Selesai</option>
                        <option>Proses</option>
                    </select>
                </div>

                <!-- Data Table -->
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Sampah</th>
                                <th>Berat (kg)</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10 Oktober 2025</td>
                                <td>
                                    <div class="table-item-name">
                                        <div class="table-item-icon table-item-icon-green">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <span>Botol Plastik</span>
                                    </div>
                                </td>
                                <td>15.0</td>
                                <td class="table-amount">Rp 45.000</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td>
                                    <button class="btn-detail">Detail</button>
                                </td>
                            </tr>
                            <tr>
                                <td>8 Oktober 2025</td>
                                <td>
                                    <div class="table-item-name">
                                        <div class="table-item-icon table-item-icon-green">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <span>Kardus</span>
                                    </div>
                                </td>
                                <td>22.5</td>
                                <td class="table-amount">Rp 67.500</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td>
                                    <button class="btn-detail">Detail</button>
                                </td>
                            </tr>
                            <tr>
                                <td>5 Oktober 2025</td>
                                <td>
                                    <div class="table-item-name">
                                        <div class="table-item-icon table-item-icon-green">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <span>Kaleng Aluminium</span>
                                    </div>
                                </td>
                                <td>8.5</td>
                                <td class="table-amount">Rp 42.500</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                                <td>
                                    <button class="btn-detail">Detail</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
