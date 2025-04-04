@props([
    'id' => 'confirmModal',
    'title' => 'Confirmar ação',
    'message' => 'Tem certeza que deseja continuar?',
    'confirmText' => 'Confirmar',
    'cancelText' => 'Cancelar',
    'type' => 'warning',
    'confirmRoute' => '',
    'confirmAction' => '',
    'method' => 'POST'
])

<div class="modal fade modal-modern modal-confirm" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="icon-container {{ $type }}">
                    <i class="fas fa-{{ $type === 'danger' ? 'exclamation-triangle' : ($type === 'success' ? 'check' : 'exclamation-circle') }}"></i>
                </div>
                <h4 class="confirm-title">{{ $title }}</h4>
                <p class="confirm-message">{{ $message }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">{{ $cancelText }}</button>

                @if ($confirmRoute)
                    <form action="{{ $confirmRoute }}" method="{{ $method }}">
                        @csrf
                        @if (strtoupper($method) === 'DELETE')
                            @method('DELETE')
                        @endif
                        {{ $slot ?? '' }}
                        <button type="submit" class="btn btn-confirm">{{ $confirmText }}</button>
                    </form>
                @else
                    <button type="button" class="btn btn-confirm" @if($confirmAction) onclick="{{ $confirmAction }}" @endif>
                        {{ $confirmText }}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

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

<script>
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
