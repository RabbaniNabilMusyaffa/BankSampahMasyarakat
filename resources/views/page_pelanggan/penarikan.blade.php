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
       @include('navbar.nav-pelanggan')

        @if(session('error') || $errors->any())
        <script>
            let errorMsg = '{{ session('error') ?? $errors->first() }}';
            Swal.fire('Gagal', errorMsg, 'error');
        </script>
    @endif

        <main class="main-content">
            <div class="content-wrapper">
                <div class="page-header">
                    <h1 class="page-title">Penarikan Dana</h1>
                    <p class="page-subtitle">Tarik saldo Anda dengan mudah dan aman</p>
                </div>

                <div class="withdrawal-grid">
                    {{-- form penarikan --}}
                    <div class="withdrawal-form-card card-base">
    <div class="balance-display">
        <p class="balance-label">Saldo Tersedia</p>
        <h2 class="balance-amount">Rp {{ number_format($jumlahSaldo ?? 0, 0, ',', '.') }}</h2>
    </div>

    <form class="withdrawal-form card-base"
      method="POST"
      action="{{ route('pengajuan') }}">

    @csrf

    <div class="form-group">
        <label class="form-label">Jumlah Penarikan</label>

        <input type="number"
               name="jumlah"
               placeholder="Masukkan jumlah"
               class="form-input"
               required
               min="50000">  {{-- <-- 1. VALIDASI HTML (CLIENT-SIDE) --}}

        <p class="form-helper">Minimum penarikan Rp 50.000</p>

        {{-- 2. TAMPILKAN ERROR DARI SERVER (SERVER-SIDE) --}}
        @error('jumlah')
            <small style="color: red; margin-top: 5px;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label">Metode Penarikan</label>
        <select name="metode" class="form-input">
            <option value="Tunai">Tunai</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Ajukan Penarikan
    </button>
</form>
    </div>

<div class="withdrawal-history-card card-base">
    <h3 class="section-title">Riwayat Penarikan</h3>
    <div class="transaction-list">

    @forelse($riwayatTarik ?? [] as $tarik)
    <div class="transaction-item">
        <div class="transaction-icon transaction-icon-blue">
            {{-- KODE SVG YANG HILANG --}}
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            {{-- AKHIR KODE SVG --}}
        </div>
        <div class="transaction-details">
            <p class="transaction-name">Penarikan {{ $tarik->catatan ?? 'Tunai' }}</p>
            <p class="transaction-date">{{ \Carbon\Carbon::parse($tarik->tanggal_request)->format('d F Y') }}</p>
        </div>
        <div class="transaction-amount transaction-amount-negative">
            {{-- TAMBAHKAN TANDA MINUS (-) --}}
            <p>- Rp {{ number_format($tarik->jumlah, 0, ',', '.') }}</p>

            @if($tarik->status == 'approved')
                <span class="transaction-status transaction-status-success">Berhasil</span>
            @elseif($tarik->status == 'rejected')
                <span class="transaction-status transaction-status-danger" style="background-color: #fee2e2; color: #dc2626;">Ditolak</span>
            @else
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
</div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('javascript/pelanggan.js') }}"></script>
</body>
</html>
