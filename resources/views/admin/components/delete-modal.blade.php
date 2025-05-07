{{-- Shared Delete Confirmation Modal --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteModalMessage">Tem certeza que deseja excluir este item?</p>
                {{-- Optional: Add item name display --}}
                <p><strong>Item:</strong> <span id="deleteModalItemName" class="fw-bold"></span></p>
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
