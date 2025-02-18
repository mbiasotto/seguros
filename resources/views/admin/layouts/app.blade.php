<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPanel - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-800 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white text-xl font-semibold">Admin Panel</span>
            </div>

            <!-- Navigation -->
            <nav class="mt-5 px-2">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-home mr-4 text-gray-400 group-hover:text-gray-300"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-4 text-gray-400 group-hover:text-gray-300"></i>
                    Vendedores
                </a>
                <a href="{{ route('admin.establishments.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-store mr-4 text-gray-400 group-hover:text-gray-300"></i>
                    Estabelecimentos
                </a>
            </nav>
        </div>

        <!-- Overlay -->
        <div
            data-overlay
            class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 hidden md:hidden transition-opacity duration-300 ease-in-out"
        ></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden md:pl-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between h-16 px-4">
                    <!-- Mobile menu button -->
                    <button
                        data-mobile-menu
                        class="md:hidden text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Search -->
                    <div class="flex-1 px-4 ml-4">
                        <div class="max-w-md w-full relative">
                            <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- User menu -->
                    <div class="ml-4 flex items-center">
                        <div class="relative">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                                <span>John Doe</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('[data-overlay]');
        const mobileMenuBtn = document.querySelector('[data-mobile-menu]');

        function toggleMobileMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        mobileMenuBtn.addEventListener('click', toggleMobileMenu);
        overlay.addEventListener('click', toggleMobileMenu);

        // Close mobile menu on window resize if screen becomes larger
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768 && !sidebar.classList.contains('md:translate-x-0')) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
