@extends('navbar.nav-petugas')

@section('title', 'Validasi Penarikan - Bank Sampah')

@section('page-title', 'Validasi Penarikan Saldo')

@section('content')
    <!-- Alert Success -->
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 24px;">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <span style="font-size: 24px;">❌</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Request Penarikan Pending -->
    <div class="content-box">
        <h2>Validasi Penarikan Saldo</h2>
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

        {{-- PERBAIKAN 1: Gunakan 'name' (pakai 'e') --}}
        <td>{{ $penarikan->pelanggan->name ?? 'User Dihapus' }}</td>

        <td>Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>

        {{-- PERBAIKAN 2: 'keterangan' diubah menjadi 'catatan' --}}
        <td>{{ $penarikan->catatan ?? '-' }}</td>

        <td><span class="badge badge-warning">Pending</span></td>
        <td>
            {{-- PERBAIKAN 1: Gunakan 'name' (pakai 'e') --}}
            <button class="btn btn-success" onclick="approvePenarikan({{ $penarikan->id }}, '{{ $penarikan->pelanggan->name ?? 'User' }}', {{ $penarikan->jumlah }})">
                ✓ Setujui
            </button>

            {{-- PERBAIKAN 1: Gunakan 'name' (pakai 'e') --}}
            <button class="btn btn-danger" onclick="rejectPenarikan({{ $penarikan->id }}, '{{ $penarikan->pelanggan->name ?? 'User' }}')">
                ✗ Tolak
            </button>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" style="text-align: center; padding: 40px;">
            <div style="color: #a0aec0;">
                <span style="font-size: 48px;"></span>
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
        <h2>Riwayat Validasi</h2>
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
    // FUNGSI APPROVE (SUDAH DIPERBAIKI)
    function approvePenarikan(id, nama, jumlah) {
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: `Setujui penarikan saldo atas nama ${nama} sebesar Rp ${jumlah.toLocaleString('id-ID')}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('approveForm');

                // PERBAIKAN: Hapus '/petugas' dari URL
                form.action = `/validasi/${id}/approve`;

                form.submit();
            }
        });
    }

    // FUNGSI REJECT (SUDAH DIPERBAIKI)
    function rejectPenarikan(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: `Masukkan alasan penolakan penarikan atas nama ${nama}:`,
            icon: 'warning',
            input: 'textarea',
            inputPlaceholder: 'Alasan penolakan harus diisi...',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value || value.trim() === '') {
                    return 'Alasan penolakan harus diisi!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                document.getElementById('alasanPenolakan').value = result.value;
                const form = document.getElementById('rejectForm');

                // PERBAIKAN: Hapus '/petugas' dari URL
                form.action = `/validasi/${id}/reject`;

                form.submit();
            }
        });
    }
</script>
@endpush
