<div class="topbar">
    <div>
        <button id="sidebarToggle" class="btn btn-light btn-sm">
            <i class="fas fa-bars"></i>
        </button>
        <span class="ms-3 d-none d-md-inline-block">@yield('page-title', 'Dashboard')</span>
    </div>
    
    <div class="user-profile">
        <div class="dropdown">
            <a class="d-flex align-items-center" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="d-none d-md-block">
                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                    <div class="small text-muted">Calon Mahasiswa</div>
                </div>
                <i class="fas fa-chevron-down ms-2 text-muted"></i>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user me-2"></i> Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>