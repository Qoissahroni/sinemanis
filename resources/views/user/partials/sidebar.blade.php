<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('user.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/logo-icon.png') }}" alt="SINEMANIS" class="img-fluid">
        </a>
        <p class="mt-2 mb-0">SINEMANIS</p>
    </div>
    
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('user.formulir.index') }}" class="{{ request()->routeIs('user.formulir*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Formulir Pendaftaran
            </a>
        </li>
        <li>
            <a href="{{ route('user.pembayaran.index') }}" class="{{ request()->routeIs('user.pembayaran*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Pembayaran
            </a>
        </li>
        <li>
            <a href="{{ route('user.laporan.index') }}" class="{{ request()->routeIs('user.laporan*') ? 'active' : '' }}">
                <i class="fas fa-file-pdf"></i> Laporan
            </a>
        </li>
        <li>
            <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile*') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profil
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