@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    {!! session('error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
    {!! session('warning') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

@if(session('info'))
<div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
    {!! session('info') !!}
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

@push('scripts')
<script>
    // Configuração para alertas com auto dismiss
    document.addEventListener('DOMContentLoaded', function() {
        const autoDismissAlerts = document.querySelectorAll('.alert[data-auto-dismiss]');
        autoDismissAlerts.forEach(alert => {
            const timeout = parseInt(alert.getAttribute('data-auto-dismiss')) || 5000;
            setTimeout(() => {
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) closeBtn.click();
            }, timeout);
        });

        // Configuração para o modal de confirmação de exclusão
        const deleteButtons = document.querySelectorAll('[data-delete-url]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-delete-url');
                const title = this.getAttribute('data-delete-title') || 'Excluir Item';
                const message = this.getAttribute('data-delete-message') || 'Tem certeza que deseja excluir este item?';
                const confirmText = this.getAttribute('data-delete-confirm') || 'Sim, Excluir';
                const cancelText = this.getAttribute('data-delete-cancel') || 'Cancelar';

                const modal = document.getElementById('deleteConfirmModal');
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);

                modal.querySelector('#deleteModalTitle').textContent = title;
                modal.querySelector('#deleteModalMessage').textContent = message;
                modal.querySelector('#deleteModalForm').action = url;
                modal.querySelector('#deleteConfirmButton').textContent = confirmText;
                modal.querySelector('#deleteCancelButton').textContent = cancelText;

                modalInstance.show();
            });
        });
    });
</script>
@endpush
