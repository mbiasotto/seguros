<div class="sidebar" id="sidebar">
    <div class="brand">
        <i class="fas fa-shield-alt"></i>
        <span>Segura Essa</span>
    </div>
    <nav class="nav flex-column">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i>
            <span>Administradores</span>
        </a>
        <a href="{{ route('admin.vendors.index') }}" class="nav-link {{ request()->routeIs('admin.vendors*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Vendedores</span>
        </a>
        <a href="{{ route('admin.establishments.index') }}" class="nav-link {{ request()->routeIs('admin.establishments*') && !request()->routeIs('admin.establishments.documents*') ? 'active' : '' }}">
            <i class="fas fa-store"></i>
            <span>Estabelecimentos</span>
        </a>
        <a href="{{ route('admin.establishments.documents.pending') }}" class="nav-link {{ request()->routeIs('admin.establishments.documents*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Documentos</span>
        </a>
        <a href="{{ route('admin.qr-codes.index') }}" class="nav-link {{ request()->routeIs('admin.qr-codes*') ? 'active' : '' }}">
            <i class="fas fa-qrcode"></i>
            <span>QR Codes</span>
        </a>
    </nav>
    <a href="/admin/logout" class="btn btn-logout mt-auto">
        <i class="fas fa-sign-out-alt me-2"></i>
        <span>Sair</span>
    </a>
</div>

<!-- Botão para menu mobile -->
<div class="mobile-menu-toggle d-md-none">
    <button class="btn btn-light shadow-sm" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')">
        <i class="fas fa-bars"></i>
    </button>
</div>
