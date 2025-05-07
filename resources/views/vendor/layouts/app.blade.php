<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Painel Vendedor</title>

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

    <!-- Estilos específicos -->
    @stack('styles')
</head>
<body>
    <!-- Header Mobile -->
    <header class="mobile-header d-md-none">
        <div class="mobile-header-container">
            {{-- TODO: Use vendor-specific logo if available --}}
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
        @include('vendor.partials.sidebar')

        <!-- Conteúdo principal -->
        <main class="main-content p-4 flex-grow-1">
            <!-- Alertas e mensagens -->
            @include('admin.partials.alerts') {{-- Reverting to use admin alerts as vendor one doesn't exist --}}

            <!-- Conteúdo da página -->
            @yield('content')
        </main>
    </div>

    {{-- Use the shared admin component modal for consistency --}}
    @include('admin.components.delete-modal') {{-- Correct path confirmed --}}
    @include('admin.components.qr-code-remove-modal') {{-- Include QR code modal as well --}}


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Script de máscaras centralizado -->
    <script src="{{ asset('assets/js/utils/input-masks.js') }}"></script> {{-- Corrected Path --}}
    <script src="{{ asset('assets/js/utils/cep-lookup.js') }}"></script> {{-- Added CEP lookup --}}

    <!-- Script admin principal (assuming vendor uses similar base JS) -->
    <script src="{{ asset('assets/admin/admin.js') }}"></script>
    {{-- Use admin modal JS unless a specific vendor one exists --}}
    <script src="{{ asset('assets/admin/js/modal.js') }}"></script>
    <script src="{{ asset('assets/admin/js/form-utils.js') }}"></script>

    <!-- Script global de tooltips -->
    <script>
        $(document).ready(function() {
            // Inicializar todos os tooltips do Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: document.body // Adjust boundary if needed
                });
            });

            // Delete modal logic is likely handled globally by modal.js included earlier
            // Ensure modal.js correctly targets '#deleteConfirmModal' from the included component
        });
    </script>

    <!-- Scripts específicos -->
    @stack('scripts')
</body>
</html>
