<div class="sidebar" id="sidebar">
    <div class="brand">
        {{-- TODO: Use vendor-specific logo if available --}}
        <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="Logo" class="sidebar-logo">
    </div>
    <nav class="nav flex-column">
        <a href="{{ route('vendor.dashboard') }}" class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('vendor.establishments.index') }}" class="nav-link {{ request()->routeIs('vendor.establishments*') && !request()->routeIs('vendor.establishments.documents*') ? 'active' : '' }}">
            <i class="fas fa-store"></i>
            <span>Estabelecimentos</span>
        </a>
        <a href="{{ route('vendor.profile') }}" class="nav-link {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Meu Perfil</span>
        </a>
        {{-- <a href="{{ route('vendor.establishments.documents') }}" class="nav-link {{ request()->routeIs('vendor.establishments.documents*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Documentos</span>
        </a> --}}
    </nav>
    <a href="/vendor/logout" class="btn btn-logout mt-auto">
        <i class="fas fa-sign-out-alt me-2"></i> {{-- Added me-2 for spacing --}}
        <span>Sair</span> {{-- Wrapped text in span for consistency --}}
    </a>
</div>
