@extends('layouts.app')

@section('title', 'Input Setoran - Bank Sampah')

@section('page-title', 'Input Setoran Sampah')

@section('content')
    <!-- Button Tambah Setoran -->
    <div class="content-box">
        <h2>📝 Input Setoran Sampah</h2>
        <button class="btn btn-primary" onclick="showModal('setoranModal')">
            <span>➕</span> Tambah Setoran Baru
        </button>
    </div>

    <!-- Alert Success (jika ada) -->
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 24px;">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Daftar Setoran Hari Ini -->
    <div class="content-box">
        <h2>📋 Daftar Setoran Hari Ini</h2>
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Pelanggan</th>
                    <th>Kategori</th>
                    <th>Berat (Kg)</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tableSetoran">
                @forelse($setorans ?? [] as $setoran)
                <tr>
                    <td>{{ $setoran->created_at->format('H:i') }}</td>
                    <td>{{ $setoran->pelanggan->nama ?? $setoran->pelanggan_nama }}</td>
                    <td>{{ $setoran->kategori->nama ?? $setoran->kategori_nama }}</td>
                    <td>{{ number_format($setoran->berat, 1) }}</td>
                    <td>Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                    <td><span class="badge badge-success">Selesai</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #718096;">Belum ada data setoran hari ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL INPUT SETORAN -->
    <div id="setoranModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>📝 Input Setoran Sampah</h3>
                <button class="close-modal" onclick="closeModal('setoranModal')">×</button>
            </div>
            <form action="" method="POST" onsubmit="return validateForm(event)">
                @csrf
                <div class="form-group">
                    <label>Pilih Pelanggan *</label>
                    <select name="pelanggan_id" id="pelanggan" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans ?? [] as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                        @endforeach
                    </select>
                    @error('pelanggan_id')
                        <small style="color: #e53e3e;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kategori Sampah *</label>
                    <select name="kategori_id" id="kategori" required onchange="hitungTotal()">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris ?? [] as $kategori)
                        <option value="{{ $kategori->id }}" data-harga="{{ $kategori->harga_per_kg }}">
                            {{ $kategori->nama }} (Rp {{ number_format($kategori->harga_per_kg, 0, ',', '.') }}/kg)
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <small style="color: #e53e3e;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Berat (Kg) *</label>
                    <input type="number" name="berat" id="berat" step="0.1" placeholder="0.0" required oninput="hitungTotal()">
                    @error('berat')
                        <small style="color: #e53e3e;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="text" id="total" readonly placeholder="Rp 0">
                    <input type="hidden" name="total_harga" id="total_harga">
                </div>

                <div class="total-display" id="totalDisplay" style="display: none;">
                    <h3>Total: <span id="totalNominal">Rp 0</span></h3>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)"></textarea>
                </div>

                <button type="submit" class="btn btn-success">✓ Simpan Setoran</button>
                <button type="button" class="btn btn-danger" onclick="closeModal('setoranModal')">✗ Batal</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Fungsi untuk menampilkan modal
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

// Fungsi untuk menutup modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    // Reset form jika perlu
    document.querySelector('#' + modalId + ' form').reset();
    document.getElementById('totalDisplay').style.display = 'none';
}

// Tutup modal jika klik di luar modal content
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Override fungsi hitungTotal untuk Laravel
function hitungTotal() {
    const kategoriSelect = document.getElementById('kategori');
    const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
    const hargaPerKg = selectedOption.getAttribute('data-harga');
    const berat = document.getElementById('berat').value;
    
    if (hargaPerKg && berat) {
        const total = parseFloat(hargaPerKg) * parseFloat(berat);
        document.getElementById('total').value = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('total_harga').value = total;
        document.getElementById('totalNominal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('totalDisplay').style.display = 'block';
    } else {
        document.getElementById('total').value = 'Rp 0';
        document.getElementById('total_harga').value = 0;
        document.getElementById('totalNominal').textContent = 'Rp 0';
        document.getElementById('totalDisplay').style.display = 'none';
    }
}

// Validasi form sebelum submit
function validateForm(event) {
    const totalHarga = document.getElementById('total_harga').value;
    if (!totalHarga || totalHarga == 0) {
        alert('⚠️ Mohon lengkapi data kategori dan berat sampah!');
        event.preventDefault();
        return false;
    }
    return true;
}
</script>
@endpush