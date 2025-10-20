<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Bank Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
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
    <div class="app-container">
        @include('navbar.navigation')

        <main class="main-content">
            <div class="content-wrapper">
                <div class="page-header">
                    <h1 class="page-title">Pengaturan Akun</h1>
                    <p class="page-subtitle">Kelola akun dan preferensi Anda</p>
                </div>

                {{-- profile --}}
                <div class="settings-card">
                    <h3 class="section-title">Informasi Profile</h3>
                    <div class="profile-section">
                        <div class="profile-avatar-large">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <button class="btn-secondary">Ubah Foto</button>
                    </div>

                    <form class="settings-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" value="Budi Santoso" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" value="budi@email.com" class="form-input">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" value="+62 812-3456-7890" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea rows="3" class="form-input">Jl. Merdeka No. 123, Surabaya</textarea>
                        </div>

                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    </form>
                </div>

                {{-- keamanan --}}
                <div class="settings-card">
                    <h3 class="section-title">Keamanan</h3>
                    <div class="settings-list">
                        <button class="settings-item">
                            <div class="settings-item-content">
                                <svg class="settings-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                <div>
                                    <p class="settings-item-title">Ubah Password</p>
                                    <p class="settings-item-desc">Perbarui password Anda secara berkala</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <button class="settings-item">
                            <div class="settings-item-content">
                                <svg class="settings-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <div>
                                    <p class="settings-item-title">Verifikasi 2 Langkah</p>
                                    <p class="settings-item-desc">Tingkatkan keamanan akun Anda</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- notif --}}
                <div class="settings-card">
                    <h3 class="section-title">Notifikasi</h3>
                    <div class="settings-list">
                        <label class="settings-toggle">
                            <div class="settings-item-content">
                                <svg class="settings-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <div>
                                    <p class="settings-item-title">Setoran Berhasil</p>
                                    <p class="settings-item-desc">Notifikasi saat setoran diproses</p>
                                </div>
                            </div>
                            <input type="checkbox" checked class="toggle-input">
                        </label>

                        <label class="settings-toggle">
                            <div class="settings-item-content">
                                <svg class="settings-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <div>
                                    <p class="settings-item-title">Penarikan Dana</p>
                                    <p class="settings-item-desc">Notifikasi status penarikan</p>
                                </div>
                            </div>
                            <input type="checkbox" checked class="toggle-input">
                        </label>

                        <label class="settings-toggle">
                            <div class="settings-item-content">
                                <svg class="settings-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <div>
                                    <p class="settings-item-title">Promo & Update</p>
                                    <p class="settings-item-desc">Info promo dan fitur terbaru</p>
                                </div>
                            </div>
                            <input type="checkbox" class="toggle-input">
                        </label>
                    </div>
                </div>

                {{-- peringatan --}}
                <div class="settings-card settings-card-danger">
                    <h3 class="section-title text-red-600">Zona Berbahaya</h3>
                    <div class="settings-list">
                        <button class="settings-item">
                            <div class="settings-item-content">
                                <svg class="settings-icon text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <div>
                                    <p class="settings-item-title text-red-600">Hapus Akun</p>
                                    <p class="settings-item-desc">Hapus akun Anda secara permanen</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('javascript/pelanggan.js') }}"></script>
</body>
</html>
