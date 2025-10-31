@extends('admin-layouts.app')

@section('title', 'Dashboard - Bank Sampah Admin')

@section('page-title', 'Dashboard Bank Sampah')

@section('content')
<div class="alert alert-success">
    <span style="font-size: 24px;">👋</span>
    <span>Selamat datang, <strong>{{ Auth::user()->name ?? 'Admin Utama' }}</strong>! Anda login sebagai {{ ucfirst(Auth::user()->role ?? 'Administrator') }}.</span>
</div>

<div class="stats-grid">
    <div class="stat-card green">
        <div class="stat-header">
            <div>
                <div class="stat-title">Total Pelanggan</div>
                <div class="stat-value">0</div>
                <div class="stat-label">Pengguna terdaftar</div>
            </div>
            <div class="stat-icon">👥</div>
        </div>
    </div>

    <div class="stat-card blue">
        <div class="stat-header">
            <div>
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value">0</div>
                <div class="stat-label">Semua transaksi</div>
            </div>
            <div class="stat-icon">📊</div>
        </div>
    </div>

    <div class="stat-card orange">
        <div class="stat-header">
            <div>
                <div class="stat-title">Total Sampah</div>
                <div class="stat-value">0</div>
                <div class="stat-label">Kilogram (Kg)</div>
            </div>
            <div class="stat-icon">♻️</div>
        </div>
    </div>
</div>

<div class="content-box">
    <h2>📈 Statistik Bulanan</h2>
    <div class="activity-card success">
        <div class="activity-icon">📊</div>
        <div class="activity-content">
            <h3>Transaksi Bulan Ini</h3>
            <p>Terdapat <strong>0 transaksi</strong> yang telah diproses bulan ini dengan total sampah terkumpul mencapai <strong>0 kg</strong>.</p>
        </div>
    </div>

    <div class="activity-card info">
        <div class="activity-icon">👥</div>
        <div class="activity-content">
            <h3>Pelanggan Aktif</h3>
            <p>Sebanyak <strong>0 pelanggan aktif</strong> telah melakukan transaksi setoran sampah dalam 30 hari terakhir.</p>
        </div>
    </div>

    <div class="activity-card warning">
        <div class="activity-icon">💰</div>
        <div class="activity-content">
            <h3>Total Saldo Sistem</h3>
            <p>Saldo total di sistem mencapai <strong>Rp 0</strong>.</p>
        </div>
    </div>
</div>

<div class="content-box">
    <h2>📋 Transaksi Terbaru</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Jenis</th>
                <th>Detail</th>
                <th>Nominal</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    <span style="font-size: 48px;">📭</span>
                    <p style="margin-top: 10px; color: #666;">Belum ada transaksi</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    console.log('Dashboard loaded successfully!');
</script>
@endpush