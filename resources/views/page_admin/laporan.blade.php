@extends('admin-layouts.app')

@section('title', 'Laporan - Bank Sampah Admin')

@section('page-title', 'Laporan Transaksi')

@section('content')
<div class="content-box">
    <h2>📊 Laporan Transaksi</h2>

    <form action="{{ route('admin.laporan') }}" method="GET" class="filter-section">
        <label class="filter-label">Filter Periode:</label>
        <div class="filter-inputs">
            <input type="date" name="start_date" id="filterStart" class="date-input" value="{{ request('start_date') }}">
            <span class="date-separator">s/d</span>
            <input type="date" name="end_date" id="filterEnd" class="date-input" value="{{ request('end_date') }}">
            <button type="submit" class="btn btn-primary">🔍 Filter</button>
            <a href="{{ route('admin.laporan') }}" class="btn btn-danger">🔄 Reset</a>
        </div>
    </form>



    <div class="export-buttons">
        <a href="{{ route('admin.pdf', request()->query()) }}" class="btn btn-danger">📄 Export PDF</a>
        <a href="{{ route('admin.excel', request()->query()) }}" class="btn btn-success">📊 Export Excel</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Berat (Kg)</th>
                <th>Nominal</th>
                <th>Petugas</th>
            </tr>
            @forelse ( $data_laporan as $laporan)
            <tr>
                <td>{{$laporan->created_at}}</td>
                @if ($laporan instanceof \App\Models\TransaksiTarik)
                <td>{{$laporan->pelanggan->name ?? 'N/A'}}</td>
                <td>Penarikan</td>
                <td>{{ $laporan->status }}</td>
                <td></td>
                <td>{{ $laporan->jumlah }}</td>
                <td>{{$laporan->validator->name}}</td>
                @else
                <td>{{$laporan->user->name ?? 'N/A'}}</td>
                <td>{{$laporan->catatan}}</td>
                <td>{{$laporan->detailSetor->first()?->kategoriSampah?->nama_kategori ?? 'N/A'}}</td>
                <td>{{$laporan->total_berat}}</td>
                <td>{{$laporan->total_harga}}</td>
                <td>{{$laporan->petugas->name}}</td>
                @endif
            </tr>
        </thead>
        @empty
        <tbody>
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px;">
                    <span style="font-size: 48px;">📭</span>
                    <p style="margin-top: 10px; color: #666;">Belum ada data transaksi.</p>
                </td>
            </tr>
        </tbody>
        @endforelse
    </table>
</div>

<div class="content-box">
    <h2>📈 Ringkasan Laporan</h2>
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Setoran</div>
                    <div class="stat-value">{{ number_format($total_berat ?? 0, 1) }}</div>
                    <div class="stat-label">Kilogram (Kg)</div>
                </div>
                <div class="stat-icon">♻️</div>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Penarikan</div>
                    <div class="stat-value">Rp {{ number_format($total_penarikan ?? 0) }}</div>
                    <div class="stat-label">Semua penarikan</div>
                </div>
                <div class="stat-icon">💰</div>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Saldo Tersisa</div>
                    <div class="stat-value">Rp {{ number_format($saldo_keseluruhan ?? 0) }}</div>
                    <div class="stat-label">Saldo sistem</div>
                </div>
                <div class="stat-icon">💳</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi filter tanggal
    document.querySelector('.filter-section').addEventListener('submit', function(e) {
        const startDate = document.getElementById('filterStart').value;
        const endDate = document.getElementById('filterEnd').value;

        if (!startDate || !endDate) {
            e.preventDefault();
            alert('Mohon pilih tanggal mulai dan tanggal akhir!');
            return false;
        }

        if (new Date(startDate) > new Date(endDate)) {
            e.preventDefault();
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
            return false;
        }
    });

    console.log('Laporan page loaded successfully!');
</script>
@endpush
