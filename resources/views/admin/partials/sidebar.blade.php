<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/logo-icon.png') }}" alt="SINEMANIS" class="img-fluid">
        </a>
        <p class="mt-2 mb-0">SINEMANIS Admin</p>
    </div>
    
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.pendaftar.index') }}" class="{{ request()->routeIs('admin.pendaftar*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Manajemen Pendaftaran
            </a>
        </li>
        <li>
            <a href="{{ route('admin.transaksi.index') }}" class="{{ request()->routeIs('admin.transaksi*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Data Transaksi
            </a>
        </li>
        <li>
            <a href="{{ route('admin.prodi.index') }}" class="{{ request()->routeIs('admin.prodi*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i> Program Studi
            </a>
        </li>
        <li>
            <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Laporan & Statistik
            </a>
        </li>
        <li>
            <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profil Admin
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>