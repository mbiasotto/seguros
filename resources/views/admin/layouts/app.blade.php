<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Sistema de Gestão</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/admin/img/favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Admin Principal -->
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">

    <!-- CSS de componentes -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/components/pagination.css') }}">

    <!-- Estilos específicos -->
    @stack('styles')
</head>
<body>
    <!-- Header Mobile -->
    <header class="mobile-header d-md-none">
        <div class="mobile-header-container">
            <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="Logo" class="mobile-logo">
            <button class="btn mobile-toggle-btn" type="button">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <div class="d-flex">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Conteúdo principal -->
        <main class="main-content p-4 flex-grow-1">
            <!-- Alertas e mensagens -->
            @include('admin.partials.alerts')

            <!-- Conteúdo da página -->
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Script de máscaras centralizado -->
    <script src="{{ asset('assets/js/utils/input-masks.js') }}"></script> {{-- Corrected Path --}}
    <script src="{{ asset('assets/js/utils/cep-lookup.js') }}"></script> {{-- Added CEP lookup --}}

    <!-- Script admin principal -->
    <script src="{{ asset('assets/admin/admin.js') }}"></script>
    <script src="{{ asset('assets/admin/js/modal.js') }}"></script>
    <script src="{{ asset('assets/admin/js/form-utils.js') }}"></script>

    <!-- Script global de tooltips -->
    <script>
        $(document).ready(function() {
            // Inicializar todos os tooltips do Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: document.body
                });
            });
        });
    </script>

    <!-- Scripts específicos -->
    @stack('scripts')
</body>
</html>
