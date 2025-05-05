<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Scripts and Styles -->
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Base Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components/modal.css') }}" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Mobile menu toggle button - Move to right side -->
        <div class="mobile-menu-toggle">
            <button type="button" class="text-gray-500 focus:outline-none" data-tooltip="Abrir Menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Sidebar for desktop -->
        <div id="sidebar" class="lg:block lg:flex-col lg:w-64 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-semibold text-gray-800">Admin Panel</a>
                <button class="sidebar-close" data-tooltip="Fechar Menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150 nav-link">
                    <i class="fas fa-home w-5 h-5 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150 nav-link">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span class="font-medium">Vendors</span>
                </a>
                <a href="{{ route('admin.establishments.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150 nav-link">
                    <i class="fas fa-store w-5 h-5 mr-3"></i>
                    <span class="font-medium">Establishments</span>
                </a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1">
            <!-- Top navigation -->
            <nav class="bg-white border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Desktop sidebar toggle button -->
                        <div class="hidden lg:flex lg:items-center">
                            <button type="button" onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-600 focus:outline-none" data-tooltip="Alternar Sidebar">
                                <i class="fas fa-bars w-6 h-6"></i>
                            </button>
                        </div>

                        <!-- Right side navigation items -->
                        <div class="flex items-center">
                            <a href="/admin/logout" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" data-tooltip="Sair">
                                <i class="fas fa-sign-out-alt w-5 h-5 mr-2"></i>
                                <span class="font-medium">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    {{-- jQuery já deve ser incluído via app.js/Vite --}}
    <script src="{{ asset('js/app.js') }}"></script> {{-- Inclui Bootstrap JS e dependências --}}
    <script src="{{ asset('js/admin/admin.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> {{-- Mask precisa ser carregado --}}
    <script src="{{ asset('js/main.js') }}"></script> {{-- Assumindo que main.js tem inicializações gerais ou máscaras --}}
    <script src="{{ asset('js/utils/form-utils.js') }}"></script> {{-- Assumindo que form-utils.js tem helpers de formulário --}}

    @stack('scripts') {{-- Área para scripts específicos da página --}}
</body>
</html>
