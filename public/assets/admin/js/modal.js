/**
 * Modal de confirmação de exclusão
 * Sistema Admin
 */

$(document).ready(function() {
    // Configurar botões de exclusão
    $(document).on('click', '[data-delete-url]', function(e) {
        e.preventDefault();

        const button = $(this);
        const deleteUrl = button.data('delete-url');
        const deleteTitle = button.data('delete-title') || 'Confirmar Exclusão';
        const deleteMessage = button.data('delete-message') || 'Tem certeza que deseja excluir este item?';
        const deleteConfirm = button.data('delete-confirm') || 'Sim, Excluir';
        const deleteCancel = button.data('delete-cancel') || 'Cancelar';

        // Atualizar o modal
        $('#deleteModalLabel').text(deleteTitle);
        $('#deleteModalMessage').text(deleteMessage);
        $('#deleteConfirmButton').text(deleteConfirm);
        $('#deleteCancelButton').text(deleteCancel);
        $('#deleteModalForm').attr('action', deleteUrl);

        // Mostrar o modal
        $('#deleteConfirmModal').modal('show');
    });
});
