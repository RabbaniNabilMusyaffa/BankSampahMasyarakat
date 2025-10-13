@extends('layouts.app')

@section('title', 'Dashboard - Bank Sampah')

@section('page-title', 'Dashboard Bank Sampah')

@section('content')
    <!-- Alert Selamat Datang -->
    <div class="alert alert-success">
        <span style="font-size: 24px;">👋</span>
        <span>Selamat datang, <strong>{{ auth()->user()->name ?? 'Budi Santoso' }}</strong>! Anda login sebagai Petugas Bank Sampah.</span>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Transaksi Hari Ini</div>
                    <div class="stat-value">{{ $totalTransaksi ?? 15 }}</div>
                    <div class="stat-label">Total transaksi</div>
                </div>
                <div class="stat-icon">📊</div>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Sampah Terkumpul</div>
                    <div class="stat-value">{{ $totalSampah ?? 124 }}</div>
                    <div class="stat-label">Kilogram (Kg)</div>
                </div>
                <div class="stat-icon">♻️</div>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Request Penarikan</div>
                    <div class="stat-value">{{ $totalPenarikan ?? 3 }}</div>
                    <div class="stat-label">Menunggu validasi</div>
                </div>
                <div class="stat-icon">⏳</div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Hari Ini -->
    <div class="content-box">
        <h2>📊 Aktivitas Hari Ini</h2>
        
        <div class="activity-card success">
            <div class="activity-icon">✓</div>
            <div class="activity-content">
                <h3>Transaksi Setoran</h3>
                <p>Anda telah memproses <strong>{{ $jumlahSetoran ?? 23 }} transaksi setoran</strong> dengan total sampah <strong>{{ $beratSetoran ?? 187 }} kg</strong>.</p>
            </div>
        </div>

        <div class="activity-card warning">
            <div class="activity-icon">⏰</div>
            <div class="activity-content">
                <h3>Request Penarikan</h3>
                <p>Terdapat <strong>{{ $requestPenarikan ?? 5 }} request penarikan saldo</strong> yang menunggu validasi Anda.</p>
            </div>
        </div>

        <div class="activity-card info">
            <div class="activity-icon">📈</div>
            <div class="activity-content">
                <h3>Performa Hari Ini</h3>
                <p>Aktivitas meningkat <strong>{{ $persentaseNaik ?? 15 }}%</strong> dibandingkan hari kemarin dengan total pendapatan <strong>Rp {{ number_format($totalPendapatan ?? 374000, 0, ',', '.') }}</strong>.</p>
            </div>
        </div>
    </div>
@endsection