<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="px-4 py-3 mb-4">
            <h5 class="text-white mb-0">Painel do Vendedor</h5>
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('vendor.dashboard') }}" class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('vendor.profile') }}" class="nav-link {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>Meu Perfil</span>
            </a>
            <a href="{{ route('vendor.establishments.index') }}" class="nav-link {{ request()->routeIs('vendor.establishments*') && !request()->routeIs('vendor.establishments.documents*') ? 'active' : '' }}">
                <i class="fas fa-store"></i>
                <span>Estabelecimentos</span>
            </a>
            {{-- <a href="{{ route('vendor.establishments.documents') }}" class="nav-link {{ request()->routeIs('vendor.establishments.documents*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Documentos</span>
            </a> --}}
        </nav>
        <a href="/vendor/logout" class="btn btn-outline-light btn-sm w-100 mt-auto d-flex align-items-center justify-content-center">
            <i class="fas fa-sign-out-alt me-2"></i>Sair
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
            <!-- Mobile Toggle Button -->
            <div class="d-block d-md-none p-3">
                <button class="btn btn-sm btn-primary" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Page Content -->
            <main class="p-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    @stack('scripts')
</body>
</html>
