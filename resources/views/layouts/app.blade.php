<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bank Sampah - Petugas')</title>
    <link rel="stylesheet" href="{{ asset('css/petugas.css') }}">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
               <div class="logo-icon">
    <img src ="{{asset('img/logo-icon.png')}}" 
        style="width: 65px; height: auto;">
</div>
                <div class="logo-text">EcoBank</div>
            </div>
          <button class="toggle-btn" onclick="document.getElementById('sidebar').classList.toggle('collapsed')">☰</button>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dash_petugas') }}" class="menu-item {{ request()->routeIs('dash_petugas') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </span>
                <span class="menu-text">Dashboard</span>
            </a>
            <a href="{{ route('petugas.input-setoran') }}" class="menu-item {{ request()->routeIs('petugas.input-setoran') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                </span>
                <span class="menu-text">Input Setoran</span>
            </a>
            <a href="{{ route('petugas.validasi') }}" class="menu-item {{ request()->routeIs('petugas.validasi') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </span>
                <span class="menu-text">Validasi Penarikan</span>
            </a>
            <a href="{{ route('petugas.transaksi-harian') }}" class="menu-item {{ request()->routeIs('petugas.transaksi-harian') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </span>
                <span class="menu-text">Transaksi Hari Ini</span>
            </a>

            <!-- PEMBATAS -->
            <div style="margin: 20px 15px; height: 1px; background-color: rgba(255, 255, 255, 0.15);"></div>

            <!-- LOGOUT -->
        

<a href="#" class="menu-item" onclick="confirmLogout(event)">
    <span class="menu-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
    </span>
    <span class="menu-text">Keluar</span>
</a>

<form id="logout-form" action="{{ route('logout')}}" method="GET" style="display: none;">
    @csrf
</form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="topbar">
            <h1>@yield('page-title', 'Dashboard Bank Sampah')</h1>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'BS', 0, 2)) }}</div>
                <div class="user-details">
                    <h3>{{ auth()->user()->name ?? 'Budi Santoso' }}</h3>
                    <p>Petugas Bank Sampah</p>
                </div>
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    
    <script src="{{ asset('javascript/script.js') }}"></script>
    <script>
function confirmLogout(event) {
    // Mencegah link berjalan secara default
    event.preventDefault();

    Swal.fire({
        title: 'Yakin ingin keluar?',
        text: "Anda akan keluar dari sesi ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, keluar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        // Jika pengguna menekan tombol "Ya, keluar!"
        if (result.isConfirmed) {
            // Maka submit form logout
            document.getElementById('logout-form').submit();
        }
    });
}
</script>


   
   


    @stack('scripts')
</body>
</html>