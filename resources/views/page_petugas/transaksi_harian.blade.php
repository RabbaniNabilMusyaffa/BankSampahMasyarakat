@extends('layouts.app')

@section('title', 'Transaksi Hari Ini - Bank Sampah')

@section('page-title', 'Transaksi Hari Ini')

@section('content')
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
    <div class="content-box">
        <h2>Semua Transaksi Hari Ini</h2>
        
        <!-- Filter/Summary Info -->
        <div style="display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="background: #edf2f7; padding: 12px 20px; border-radius: 8px;">
                <strong style="color: #2d3748;">Total Transaksi:</strong> 
                <span style="color: #48bb78; font-weight: 700;"></span>
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
                <!-- @forelse($transaksis ?? [] as $transaksi) -->
                <tr>
                    <!-- <td>{{ $transaksi->created_at->format('H:i') }}</td> -->
                    <td></td>
                    <td>
                        <!-- @if($transaksi->jenis == 'setoran' || $transaksi->type == 'setoran') -->
                            <span class="badge badge-success">Setoran</span>
                        <!-- @elseif($transaksi->jenis == 'penarikan' || $transaksi->type == 'penarikan') -->
                            <span class="badge badge-info">Penarikan</span>
                        <!-- @else -->
                            <span class="badge badge-warning"></span>
                        <!-- @endif -->
                    </td>
                    <td>
                        <!-- @if($transaksi->jenis == 'setoran' || $transaksi->type == 'setoran')
                            {{ $transaksi->kategori->nama ?? $transaksi->kategori_nama ?? '-' }} - {{ number_format($transaksi->berat ?? 0, 1) }} kg
                        @else
                            {{ $transaksi->keterangan ?? 'Penarikan Saldo' }}
                        @endif -->
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- @empty -->
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        <div style="color: #a0aec0;">
                            <span style="font-size: 48px;"></span>
                            <p style="margin-top: 12px; font-size: 16px;">Belum ada transaksi hari ini</p>
                        </div>
                    </td>
                </tr>
                <!-- @endforelse -->
            </tbody>
        </table>

        <!-- Pagination -->
        <!-- @if(isset($transaksis) && method_exists($transaksis, 'links')) -->
        <div style="margin-top: 24px;">
            <!-- {{ $transaksis->links() }} -->
        </div>
        <!-- @endif -->
    </div>

    <!-- Summary Cards -->

    <div class="stats-grid" style="margin-top: 24px;">
        <div class="stat-card green">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Setoran</div>
                    <div class="stat-value"></div>
                    <div class="stat-label">Transaksi setoran</div>
                </div>
                <div class="stat-icon">📥</div>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Penarikan</div>
                    <div class="stat-value"></div>
                    <div class="stat-label">Transaksi penarikan</div>
                </div>
                <div class="stat-icon">📤</div>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Nominal</div>
                    <div class="stat-value" style="font-size: 24px;"></div>
                    <div class="stat-label">Nilai transaksi hari ini</div>
                </div>
                <div class="stat-icon">💰</div>
            </div>
        </div>
    </div>
  
@endsection