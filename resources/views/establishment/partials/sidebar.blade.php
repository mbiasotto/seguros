<div class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="Logo" class="sidebar-logo">
    </div>
    <nav class="nav flex-column">
        <a href="{{ route('establishment.dashboard') }}" class="nav-link {{ request()->routeIs('establishment.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('establishment.profile') }}" class="nav-link {{ request()->routeIs('establishment.profile') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Meu Perfil</span>
        </a>
        <a href="{{ route('establishment.change-password') }}" class="nav-link {{ request()->routeIs('establishment.change-password*') ? 'active' : '' }}">
            <i class="fas fa-lock"></i>
            <span>Alterar Senha</span>
        </a>
    </nav>
    <a href="/minhaarea/logout" class="btn btn-logout mt-auto">
        <i class="fas fa-sign-out-alt me-2"></i>
        <span>Sair</span>
    </a>
</div>
