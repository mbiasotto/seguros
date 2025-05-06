<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Painel Vendedor</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin/img/favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Admin Principal -->
    <link rel="stylesheet" href="{{ asset('admin/admin.css') }}">

    <!-- Estilos específicos -->
    @stack('styles')
</head>
<body>
    <!-- Header Mobile -->
    <header class="mobile-header d-md-none">
        <div class="mobile-header-container">
            {{-- TODO: Use vendor-specific logo if available --}}
            <img src="{{ asset('admin/img/logo-white.png') }}" alt="Logo" class="mobile-logo">
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
            @include('admin.partials.alerts')

            <!-- Conteúdo da página -->
            @yield('content')
        </main>
    </div>

    <!-- Modal de Confirmação de Exclusão (Keep the vendor-specific modal for now) -->
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Script de máscaras centralizado -->
    <script src="{{ asset('js/input-masks.js') }}"></script>

    <!-- Script admin principal -->
    <script src="{{ asset('admin/admin.js') }}"></script>
    {{-- <script src="{{ asset('admin/js/modal.js') }}"></script> --}}
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('admin/js/form-utils.js') }}"></script>

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

            // Script specific for vendor delete modal
            const deleteButtons = document.querySelectorAll('[data-delete-url]');
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
                        const url = this.getAttribute('data-delete-url');
                        const title = this.getAttribute('data-delete-title') || 'Excluir Item';
                        const message = this.getAttribute('data-delete-message') || 'Tem certeza que deseja excluir este item?';
                        const confirmText = this.getAttribute('data-delete-confirm') || 'Sim, Excluir';
                        const cancelText = this.getAttribute('data-delete-cancel') || 'Cancelar';

                        deleteModalTitle.textContent = title;
                        deleteModalMessage.textContent = message;
                        deleteModalForm.action = url;
                        deleteConfirmButton.textContent = confirmText;
                        deleteCancelButton.textContent = cancelText;
                        bsDeleteModal.show();
                    });
                });
            }
        });
    </script>

    <!-- Scripts específicos -->
    @stack('scripts')
</body>
</html>
