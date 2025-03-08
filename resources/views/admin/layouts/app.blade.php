<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPanel - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(180deg, #1D40AE 0%, #2A48A7 100%);
            min-height: 100vh;
            padding-top: 2rem;
            transition: transform 0.3s ease;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                max-width: 250px;
                z-index: 1000;
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
        .sidebar .nav-item + .nav-item {
            margin-top: 0.25rem;
        }
        .brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .navbar-toggler {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            display: none;
            padding: 0.5rem;
            background-color: #1D40AE;
            border: none;
            border-radius: 4px;
            color: white;
        }
        @media (max-width: 767.98px) {
            .navbar-toggler {
                display: block;
            }
            main {
                margin-left: 0 !important;
                padding-top: 4rem !important;
            }
        }
    </style>
</head>
<body>
    <button class="navbar-toggler" type="button" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="brand">
                    <i class="fas fa-layer-group"></i>
                    <span>PAINEL</span>
                </div>
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.vendors.index') }}">
                                <i class="fas fa-users"></i>
                                <span>Vendedores</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.establishments.index') }}">
                                <i class="fas fa-store"></i>
                                <span>Estabelecimentos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggler = document.getElementById('sidebarToggle');
            if (window.innerWidth < 768 && !sidebar.contains(event.target) && !toggler.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
