<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bank Sampah - Admin')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    
    <!-- Additional CSS -->
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">🌱</div>
                <div class="logo-text">Bank Sampah</div>
            </div>
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dash_admin') }}" class="menu-item {{ Request::routeIs('dash_admin') ? 'active' : '' }}">
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
            
            <a href="{{ route('admin.kelola') }}" class="menu-item {{ Request::routeIs('admin.kelola') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
                <span class="menu-text">Kelola User</span>
            </a>
            
            <a href="{{ route('admin.kategori') }}" class="menu-item {{ Request::routeIs('admin.kategori') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M16.24 7.76l-2.12 6.36-6.36 2.12 2.12-6.36 6.36-2.12z"></path>
                    </svg>
                </span>
                <span class="menu-text">Kategori Sampah</span>
            </a>
            
            <a href="{{ route('admin.laporan') }}" class="menu-item {{ Request::routeIs('admin.laporan') ? 'active' : '' }}">
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
                <span class="menu-text">Laporan</span>
            </a>
        </div>

        <div class="logout-item">
            <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                </span>
                <span class="menu-text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="topbar">
            <h1>@yield('page-title', 'Dashboard Bank Sampah')</h1>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'AU', 0, 2)) }}</div>
                <div class="user-details">
                    <h3>{{ Auth::user()->name ?? 'Admin Utama' }}</h3>
                    <p>{{ ucfirst(Auth::user()->role ?? 'Administrator') }}</p>
                </div>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success">
                    <span style="font-size: 20px;">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <span style="font-size: 20px;">❌</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <span style="font-size: 20px;">⚠️</span>
                    <span>
                        <strong>Terdapat kesalahan:</strong>
                        <ul style="margin: 5px 0 0 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('javascript/admin-script.js') }}"></script>
    
    <!-- Additional JS -->
    @stack('scripts')
</body>
</html>