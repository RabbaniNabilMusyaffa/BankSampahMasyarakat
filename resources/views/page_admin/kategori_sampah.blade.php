@extends('navbar.nav-admin')

@section('title', 'Kategori Sampah - Bank Sampah Admin')

@section('page-title', 'Kategori Sampah')

@section('content')
<div class="content-box">
    <h2>♻️ Kelola Kategori Sampah</h2>
    <button class="btn btn-primary" onclick="openKategoriModal('add')">
        <span>➕</span> Tambah Kategori
    </button>

    <table id="tableKategori">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Harga/Kg</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            @forelse ($data_sampah as $kategori)
            <tr>
                <td>{{ $kategori['id'] }}</td>
                <td>{{ $kategori['nama_kategori'] }}</td>
                <td>{{ $kategori['harga_per_kg'] }}</td>
                <td>{{ $kategori['deskripsi'] }}</td>
                <td>{{ $kategori['status'] }}</td>
            </tr>
        </thead>
        @empty
        <tbody>
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px;">
                    <span style="font-size: 48px;">📭</span>
                    <p style="margin-top: 10px; color: #666;">Belum ada kategori sampah. Silakan tambah kategori baru.</p>
                </td>
            </tr>
        </tbody>
        @endforelse
    </table>
</div>

<!-- MODAL TAMBAH/EDIT KATEGORI -->
<div id="kategoriModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="kategoriModalTitle">♻️ Tambah Kategori Sampah</h3>
            <button class="close-modal" onclick="closeModal('kategoriModal')">×</button>
        </div>
        <form id="kategoriForm" action="{{ route('admin.kategoriTambah') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="kategoriMethod" value="POST">
            <input type="hidden" name="kategori_id" id="kategoriId">

            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" name="nama_kategori" id="kategoriNama" placeholder="Contoh: Plastik, Kertas" required>
            </div>
            <div class="form-group">
                <label>Harga per Kg *</label>
                <input type="number" name="harga_per_kg" id="kategoriHarga" placeholder="2000" required min="0">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="kategoriDeskripsi" rows="3" placeholder="Deskripsi kategori sampah"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">✓ Simpan Kategori</button>
            <button type="button" class="btn btn-danger" onclick="closeModal('kategoriModal')">✗ Batal</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Open modal untuk tambah kategori
    function openKategoriModal(mode) {
        if (mode === 'add') {
            document.getElementById('kategoriModalTitle').textContent = '♻️ Tambah Kategori Sampah';
            document.getElementById('kategoriMethod').value = 'POST';
            document.getElementById('kategoriForm').reset();
        }
        showModal('kategoriModal');
    }
</script>
@endpush
