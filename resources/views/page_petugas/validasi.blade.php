@extends('layouts.app')

@section('title', 'Validasi Penarikan - Bank Sampah')

@section('page-title', 'Validasi Penarikan Saldo')

@section('content')
    <!-- Alert Success -->
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
    <!-- Alert Success (jika ada) -->
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 24px;">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Request Penarikan Pending -->
    <div class="content-box">
        <h2>💰 Validasi Penarikan Saldo</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penarikanPending ?? [] as $penarikan)
                <tr id="row-{{ $penarikan->id }}">
                    <td>{{ $penarikan->created_at->format('d/m/Y') }}</td>
                    <td>{{ $penarikan->pelanggan->nama ?? $penarikan->pelanggan_nama }}</td>
                    <td>Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $penarikan->keterangan ?? '-' }}</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <button class="btn btn-success" onclick="approvePenarikan({{ $penarikan->id }}, '{{ $penarikan->pelanggan->nama ?? $penarikan->pelanggan_nama }}', {{ $penarikan->jumlah }})">
                            ✓ Setujui
                        </button>
                        <button class="btn btn-danger" onclick="rejectPenarikan({{ $penarikan->id }}, '{{ $penarikan->pelanggan->nama ?? $penarikan->pelanggan_nama }}')">
                            ✗ Tolak
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        <div style="color: #a0aec0;">
                            <span style="font-size: 48px;">✅</span>
                            <p style="margin-top: 12px; font-size: 16px;">Tidak ada request penarikan yang menunggu validasi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Riwayat Validasi -->
    <div class="content-box">
        <h2>✅ Riwayat Validasi</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Divalidasi Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatValidasi ?? [] as $riwayat)
                <tr>
                    <td>{{ $riwayat->validated_at ? $riwayat->validated_at->format('d/m/Y') : $riwayat->updated_at->format('d/m/Y') }}</td>
                    <td>{{ $riwayat->pelanggan->nama ?? $riwayat->pelanggan_nama }}</td>
                    <td>Rp {{ number_format($riwayat->jumlah, 0, ',', '.') }}</td>
                    <td>
                        @if($riwayat->status == 'approved' || $riwayat->status == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($riwayat->status == 'rejected' || $riwayat->status == 'ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-info">{{ ucfirst($riwayat->status) }}</span>
                        @endif
                    </td>
                    <td>{{ $riwayat->validator->name ?? $riwayat->validator_nama ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #718096; padding: 24px;">
                        Belum ada riwayat validasi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Riwayat (jika ada) -->
        @if(isset($riwayatValidasi) && method_exists($riwayatValidasi, 'links'))
        <div style="margin-top: 24px;">
            {{ $riwayatValidasi->links() }}
        </div>
        @endif
    </div>

    <!-- Form Hidden untuk Approve -->
    <form id="approveForm" action="" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="approved">
    </form>

    <!-- Form Hidden untuk Reject -->
    <form id="rejectForm" action="" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="rejected">
        <input type="hidden" name="alasan_penolakan" id="alasanPenolakan">
    </form>
@endsection

@push('scripts')
<script>
// Approve Penarikan
function approvePenarikan(id, nama, jumlah) {
    if (confirm(`Setujui penarikan saldo atas nama ${nama} sebesar Rp ${jumlah.toLocaleString('id-ID')}?`)) {
        const form = document.getElementById('approveForm');
        form.action = `/petugas/validasi/${id}/approve`;
        form.submit();
    }
}

// Reject Penarikan
function rejectPenarikan(id, nama) {
    const alasan = prompt(`Masukkan alasan penolakan penarikan atas nama ${nama}:`);
    
    if (alasan && alasan.trim() !== '') {
        document.getElementById('alasanPenolakan').value = alasan;
        const form = document.getElementById('rejectForm');
        form.action = `/petugas/validasi/${id}/reject`;
        form.submit();
    } else if (alasan !== null) {
        alert('⚠️ Alasan penolakan harus diisi!');
    }
}
</script>
@endpush