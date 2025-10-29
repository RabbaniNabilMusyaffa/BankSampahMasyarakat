<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Setoran - Bank Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{asset('css/pelanggan.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
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
    <div class="app-container">
        @include('navbar.navigation')

        <main class="main-content">
            <div class="content-wrapper">
                <div class="page-header">
                    <h1 class="page-title">Riwayat Setoran</h1>
                    <p class="page-subtitle">Lihat semua transaksi setoran sampah Anda</p>
                </div>

                {{-- search filter --}}
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

                {{-- tabel data --}}
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

                                        <span>Botol Plastik</span>
                                    </div>
                                </td>
                                <td>15.0</td>
                                <td class="table-amount">Rp 45000</td>
                                <td><span class="transaction-status transaction-status-success">Selesai</span></td>
                                <td>
                                    <button class="btn btn-detail">Detail</button>
                                </td>
                            </tr>
                            <tr>
                                <td>8 Oktober 2025</td>
                                <td>
                                    <div class="table-item-name">

                                        <span>Kardus</span>
                                    </div>
                                </td>
                                <td>22.5</td>
                                <td class="table-amount">Rp 67500</td>
                                <td><span class="transaction-status transaction-status-success">Selesai</span></td>
                                <td>
                                    <button class="btn btn-detail">Detail</button>
                                </td>
                            </tr>
                            <tr>
                                <td>5 Oktober 2025</td>
                                <td>
                                    <div class="table-item-name">

                                        <span>Kaleng Aluminium</span>
                                    </div>
                                </td>
                                <td>8.5</td>
                                <td class="table-amount">Rp 42500</td>
                                <td><span class="transaction-status transaction-status-success">Selesai</span></td>
                                <td>
                                    <button class="btn btn-detail">Detail</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('javascript/pelanggan.js') }}"></script>
</body>
</html>
