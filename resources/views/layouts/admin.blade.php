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
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar for desktop -->
        <div id="sidebar" class="lg:block lg:flex-col lg:w-64 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out">
            <div class="p-4 border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-semibold text-gray-800">Admin Panel</a>
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                    <i class="fas fa-home w-5 h-5 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span class="font-medium">Vendors</span>
                </a>
                <a href="{{ route('admin.establishments.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-150">
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
                        <!-- Mobile menu button -->
                        <div class="flex items-center lg:hidden">
                            <button type="button" onclick="toggleMobileMenu()" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <i class="fas fa-bars w-6 h-6"></i>
                            </button>
                        </div>

                        <!-- Desktop navigation items -->
                        <div class="hidden lg:flex lg:items-center">
                            <button type="button" onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-bars w-6 h-6"></i>
                            </button>
                        </div>

                        <!-- Right side navigation items -->
                        <div class="flex items-center">
                            <a href="/admin/logout" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i class="fas fa-sign-out-alt w-5 h-5 mr-2"></i>
                                <span class="font-medium">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="lg:hidden hidden bg-white border-b border-gray-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        <i class="fas fa-home w-5 h-5 mr-3 inline-block"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.vendors.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        <i class="fas fa-users w-5 h-5 mr-3 inline-block"></i>Vendors
                    </a>
                    <a href="{{ route('admin.establishments.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                        <i class="fas fa-store w-5 h-5 mr-3 inline-block"></i>Establishments
                    </a>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('hidden');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('lg:w-64');
            sidebar.classList.toggle('lg:w-20');
        }
    </script>
</body>
</html>
