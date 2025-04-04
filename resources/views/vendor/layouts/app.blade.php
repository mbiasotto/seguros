<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor.main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/action-buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/modal.css') }}">
    @stack('styles')
    <!-- Script para desativar tooltips não desejados -->
    <script src="{{ asset('js/disable-tooltips.js') }}"></script>
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
        <a href="/vendor/logout" class="btn btn-logout mt-auto">
            <i class="fas fa-sign-out-alt"></i>Sair
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

    <!-- Modal de Confirmação de Exclusão -->
    <div id="deleteConfirmModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalTitle">Excluir Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteModalMessage">Tem certeza que deseja excluir este item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="deleteCancelButton">Cancelar</button>
                    <form id="deleteModalForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="deleteConfirmButton">Sim, Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Procura por todos os botões com atributos data-delete-*
            const deleteButtons = document.querySelectorAll('[data-delete-url]');

            // Modal de confirmação
            const deleteModal = document.getElementById('deleteConfirmModal');
            const deleteModalTitle = document.getElementById('deleteModalTitle');
            const deleteModalMessage = document.getElementById('deleteModalMessage');
            const deleteModalForm = document.getElementById('deleteModalForm');
            const deleteConfirmButton = document.getElementById('deleteConfirmButton');
            const deleteCancelButton = document.getElementById('deleteCancelButton');

            if (deleteModal && deleteButtons.length > 0) {
                const bsDeleteModal = new bootstrap.Modal(deleteModal);

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Configura o modal com os dados do botão
                        const url = this.getAttribute('data-delete-url');
                        const title = this.getAttribute('data-delete-title') || 'Excluir Item';
                        const message = this.getAttribute('data-delete-message') || 'Tem certeza que deseja excluir este item?';
                        const confirmText = this.getAttribute('data-delete-confirm') || 'Sim, Excluir';
                        const cancelText = this.getAttribute('data-delete-cancel') || 'Cancelar';

                        // Atualiza o modal
                        deleteModalTitle.textContent = title;
                        deleteModalMessage.textContent = message;
                        deleteModalForm.action = url;
                        deleteConfirmButton.textContent = confirmText;
                        deleteCancelButton.textContent = cancelText;

                        // Abre o modal
                        bsDeleteModal.show();
                    });
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
