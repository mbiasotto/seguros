<div class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="Logo" class="sidebar-logo">
    </div>
    <nav class="nav flex-column">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.clientes.index') }}" class="nav-link {{ request()->routeIs('admin.clientes*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Clientes</span>
        </a>
        <a href="{{ route('admin.establishments.index') }}" class="nav-link {{ request()->routeIs('admin.establishments*') ? 'active' : '' }}">
            <i class="fas fa-store"></i>
            <span>Estabelecimentos</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>Categorias</span>
        </a>
        <a href="{{ route('admin.contratos.index') }}" class="nav-link {{ request()->routeIs('admin.contratos*') ? 'active' : '' }}">
            <i class="fas fa-file-contract"></i>
            <span>Contratos</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i>
            <span>Administradores</span>
        </a>
        <a href="{{ route('admin.configuracoes.index') }}" class="nav-link {{ request()->routeIs('admin.configuracoes*') ? 'active' : '' }}">
            <i class="fas fa-cogs"></i>
            <span>Configurações</span>
        </a>
    </nav>

    <!-- Logout Form -->
    <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="btn btn-logout">
            <i class="fas fa-sign-out-alt me-2"></i>
            <span>Sair</span>
        </button>
    </form>
</div>
