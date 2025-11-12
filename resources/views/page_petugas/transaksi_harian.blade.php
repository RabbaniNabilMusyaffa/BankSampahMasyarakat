@extends('layouts.app')

@section('title', 'Transaksi Hari Ini - Bank Sampah')

@section('page-title', 'Transaksi Hari Ini')

@section('content')
<div class="card-body p-0">
    {{-- Tampilkan Notifikasi Sukses --}}
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 24px;">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Tampilkan Notifikasi Error --}}
    @if(session('error'))
    <div class="alert alert-danger">
        <span style="font-size: 24px;">❌</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Error Bawaan Laravel (jika ada) --}}
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
    @endif
</div>
    <div class="content-box">
        <h2>Semua Transaksi Hari Ini</h2>
        
        <div style="display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="background: #edf2f7; padding: 12px 20px; border-radius: 8px;">
                <strong style="color: #2d3748;">Total Transaksi:</strong> 
                <span style="color: #48bb78; font-weight: 700;">{{ ($jumlahSetoran ?? 0) + ($jumlahPenarikan ?? 0) }} Transaksi</span>
            </div>
            <div style="background: #edf2f7; padding: 12px 20px; border-radius: 8px;">
                <strong style="color: #2d3748;">Tanggal:</strong> 
                <span style="color: #4299e1; font-weight: 700;">{{ date('d F Y') }}</span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Pelanggan</th>
                    <th>Jenis Transaksi</th>
                    <th>Detail</th>
                    <th>Nominal</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis ?? [] as $transaksi)
                <tr>
                    <td>{{ $transaksi->waktu->format('H:i') }}</td>
                    <td>{{ $transaksi->pelanggan_data->name ?? 'N/A' }}</td>
                    <td>
                        @if($transaksi->jenis_transaksi == 'setoran')
                            <span class="badge badge-success">Setoran</span>
                        @elseif($transaksi->jenis_transaksi == 'penarikan')
                            <span class="badge badge-info">Penarikan</span>
                        @endif
                    </td>
                    <td>
                        @if($transaksi->jenis_transaksi == 'setoran')
                            {{ $transaksi->detailSetor->first()->kategoriSampah->nama_kategori ?? 'Setoran' }} - {{ number_format($transaksi->total_berat, 1) }} kg
                        @else
                            {{ $transaksi->catatan ?? 'Penarikan Saldo' }}
                        @endif
                    </td>
                    <td>
                        @if($transaksi->jenis_transaksi == 'setoran')
                            <span style="color: green; font-weight: 600;">+ Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</span>
                        @else
                            <span style="color: red; font-weight: 600;">- Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td>{{ $transaksi->petugas_data->name ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        <div style="color: #a0aec0;">
                            <span style="font-size: 48px;"></span>
                            <p style="margin-top: 12px; font-size: 16px;">Belum ada transaksi hari ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- 
        @if(isset($transaksis) && method_exists($transaksis, 'links'))
        <div style="margin-top: 24px;">
            {{ $transaksis->links() }}
        </div>
        @endif
        --}}
    </div>

    <div class="stats-grid" style="margin-top: 24px;">
        <div class="stat-card green">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Setoran</div>
                    <div class="stat-value">Rp {{ number_format($totalSetoran ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">{{ $jumlahSetoran ?? 0 }} transaksi setoran</div>
                </div>
                <div class="stat-icon">📥</div>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Penarikan</div>
                    <div class="stat-value">Rp {{ number_format($totalPenarikan ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">{{ $jumlahPenarikan ?? 0 }} transaksi penarikan</div>
                </div>
                <div class="stat-icon">📤</div>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Kas Hari Ini</div>
                    <div class="stat-value" style="font-size: 24px;">Rp {{ number_format($totalNominal ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">Setoran - Penarikan</div>
                </div>
                <div class="stat-icon">💰</div>
            </div>
        </div>
    </div>
 
@endsection