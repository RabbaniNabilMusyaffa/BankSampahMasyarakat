@extends('admin-layouts.app')

@section('title', 'Kelola User - Bank Sampah Admin')

@section('page-title', 'Kelola User')

@section('content')
<div class="content-box">
    <h2>👥 Kelola User</h2>
    <button class="btn btn-primary" onclick="openUserModal('add')">
        <span>➕</span> Tambah User Baru
    </button>

    <table id="tableUsers">
        <thead>
            <tr>
                <th>id</th>
                <th>nama</th>
                <th>email</th>
                <th>role</th>
                <th>no. hp</th>
                <th>status</th>
            </tr>
            @foreach ($data_user as $item )
            <tr>
                <td>{{$item['id']}}</td>
                <td>{{$item['name']}}</td>
                <td>{{$item['email']}}</td>
                <td>{{$item['role']}}</td>
                <td>{{$item['phone']}}</td>
                <td>{{$item['status']}}</td>
            </tr>
            @endforeach
        </thead>
        <tbody>
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    <span style="font-size: 48px;">📭</span>
                    <p style="margin-top: 10px; color: #666;">Belum ada data user. Silakan tambah user baru.</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- MODAL TAMBAH/EDIT USER -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="userModalTitle">👤 Tambah User Baru</h3>
            <button class="close-modal" onclick="closeModal('userModal')">×</button>
        </div>
        <form id="userForm" action="{{ route('admin.user') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="userMethod" value="POST">
            <input type="hidden" name="user_id" id="userId">

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="name" id="userName" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" id="userEmail" placeholder="email@example.com" required>
            </div>
            <div class="form-group">
                <label>Password <span id="passwordLabel">*</span></label>
                <input type="password" name="password" id="userPassword" placeholder="Minimal 6 karakter" required>
            </div>
            <div class="form-group">
                <label>Role *</label>
                <select name="role" id="userRole" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="tel" name="phone" id="userPhone" placeholder="08xxxxxxxxxx">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" id="userAddress" rows="3" placeholder="Alamat lengkap"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">✓ Simpan User</button>
            <button type="button" class="btn btn-danger" onclick="closeModal('userModal')">✗ Batal</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Open modal untuk tambah user
    function openUserModal(mode) {
        if (mode === 'add') {
            document.getElementById('userModalTitle').textContent = '👤 Tambah User Baru';
            document.getElementById('userMethod').value = 'POST';
            document.getElementById('userForm').reset();
            document.getElementById('userPassword').required = true;
            document.getElementById('passwordLabel').textContent = '*';
        }
        showModal('userModal');
    }
</script>
@endpush
