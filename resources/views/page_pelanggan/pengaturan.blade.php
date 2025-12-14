<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Bank Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        /* Modal Overlay */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        /* Modal Content */
        .modal-content-custom {
            background: white;
            border-radius: 12px;
            padding: 30px;
            width: 90%;
            max-width: 550px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        /* Modal Header */
        .modal-header-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-header-custom svg {
            width: 28px;
            height: 28px;
            color: #10b981;
        }

        .modal-header-custom h3 {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            margin: 0;
            flex: 1;
        }

        .modal-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .modal-close:hover {
            color: #374151;
        }

        .modal-close svg {
            width: 24px;
            height: 24px;
        }

        /* Form Groups */
        .modal-form-group {
            margin-bottom: 20px;
        }

        .modal-form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .modal-form-label .required {
            color: #ef4444;
            margin-left: 2px;
        }

        .modal-form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .modal-form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .modal-form-input::placeholder {
            color: #9ca3af;
        }

        /* Password Requirements */
        .password-requirements {
            margin-top: 12px;
            padding: 12px;
            background-color: #f9fafb;
            border-radius: 8px;
            font-size: 13px;
        }

        .password-requirements h4 {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin: 0 0 8px 0;
        }

        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
            color: #6b7280;
        }

        .password-requirements li {
            margin-bottom: 4px;
        }

        /* Modal Buttons */
        .modal-buttons {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-modal {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-modal-primary {
            background-color: #6366f1;
            color: white;
        }

        .btn-modal-primary:hover {
            background-color: #4f46e5;
        }

        .btn-modal-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-modal-danger:hover {
            background-color: #dc2626;
        }

        .btn-modal svg {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 640px) {
            .modal-content-custom {
                width: 95%;
                padding: 24px;
            }

            .modal-buttons {
                flex-direction: column-reverse;
            }
        }
    </style>
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
        @endif
    </div>





    
    <div class="app-container">
        @include('navbar.nav-pelanggan')

        <main class="main-content">
            <div class="content-wrapper">
                <div class="page-header">
                    <h1 class="page-title">Pengaturan Akun</h1>
                    <p class="page-subtitle">Kelola akun dan preferensi Anda</p>
                </div>

                {{-- profile --}}
                <div class="settings-card card-base">
                    <h3 class="section-title">Informasi Profile</h3>
                    <div class="profile-section">
                        <div class="profile-avatar-large">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <button class="btn btn-secondary">Ubah Foto</button>
                    </div>

                    <form class="settings-form" action="{{ route('pelanggan.pengaturan.update') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-input">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" name="phone" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="date" class="form-input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea rows="3" name="address" class="form-input"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>

                {{-- keamanan --}}
                <div class="settings-card">
                    <h3 class="section-title">Keamanan</h3>
                    <div class="settings-list">
                        <button class="settings-item" onclick="openPasswordModal()">
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
                <div class="settings-card card-base">
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
                <div class="settings-card settings-card-danger card-base">
                    <h3 class="section-title text-red-600">PERINGATAN</h3>
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

    <!-- Modal Ubah Password -->
    <div class="modal-overlay" id="passwordModal">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                <h3>Ubah Password</h3>
                <button type="button" class="modal-close" onclick="closePasswordModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('pelanggan.pengaturan.update') }}" method="POST">
                @csrf
                
                <div class="modal-form-group">
                    <label class="modal-form-label">
                        Password Lama <span class="required">*</span>
                    </label>
                    <input type="password" name="current_password" class="modal-form-input" placeholder="Masukkan password lama" required>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">
                        Password Baru <span class="required">*</span>
                    </label>
                    <input type="password" name="new_password" class="modal-form-input" placeholder="Masukkan password baru" required>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">
                        Konfirmasi Password Baru <span class="required">*</span>
                    </label>
                    <input type="password" name="new_password_confirmation" class="modal-form-input" placeholder="Ulangi password baru" required>
                </div>

                <div class="password-requirements">
                    <h4>Syarat Password:</h4>
                    <ul>
                        <li>Minimal 8 karakter</li>
                        <li>Kombinasi huruf besar dan kecil</li>
                        <li>Minimal 1 angka</li>
                        <li>Minimal 1 karakter spesial (@, #, $, dll)</li>
                    </ul>
                </div>

                <div class="modal-buttons">
                    <button type="button" class="btn-modal btn-modal-danger" onclick="closePasswordModal()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                    <button type="submit" class="btn-modal btn-modal-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('javascript/pelanggan.js') }}"></script>
    <script>
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('passwordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePasswordModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePasswordModal();
            }
        });
    </script>
</body>
</html>