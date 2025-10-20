<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penarikan Dana - Bank Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <h1 class="page-title">Penarikan Dana</h1>
                    <p class="page-subtitle">Tarik saldo Anda dengan mudah dan aman</p>
                </div>

                <div class="withdrawal-grid">
                    {{-- form penarikan --}}
                    <div class="withdrawal-form-card">
                        <div class="balance-display">
                            <p class="balance-label">Saldo Tersedia</p>
                            <h2 class="balance-amount">Rp 855.000,-</h2>
                        </div>

                        <form class="withdrawal-form">
                            <div class="form-group">
                                <label class="form-label">Jumlah Penarikan</label>
                                <input type="number" placeholder="Masukkan jumlah" class="form-input">
                                <p class="form-helper">Minimum penarikan Rp 50.000</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Metode Penarikan</label>
                                <select class="form-input">
                                    <option>Transfer Bank</option>
                                    <option>E-Wallet (OVO)</option>
                                    <option>E-Wallet (GoPay)</option>
                                    <option>E-Wallet (Dana)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nomor Rekening / E-Wallet</label>
                                <input type="text" placeholder="Masukkan nomor" class="form-input">
                            </div>

                            <button type="submit" class="btn-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Ajukan Penarikan
                            </button>
                        </form>
                    </div>

                    {{-- riwayat --}}
                    <div class="withdrawal-history-card">
                        <h3 class="section-title">Riwayat Penarikan</h3>
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
                                    <p>Rp 200.000</p>
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
                                    <p>Rp 150.000</p>
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
                                    <p>Rp 300.000</p>
                                    <span class="transaction-status transaction-status-success">Berhasil</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('javascript/pelanggan.js') }}"></script>
</body>
</html>
