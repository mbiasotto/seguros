/**
 * Modals Component JS
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

const AdminModals = {
    /**
     * Inicializa o sistema de modais
     */
    init: function() {
        this.setupDeleteButtons();
        this.setupConfirmButtons();
    },

    /**
     * Inicializa os botões de exclusão
     */
    setupDeleteButtons: function() {
        const deleteButtons = document.querySelectorAll('[data-delete-url]');

        if (deleteButtons.length > 0) {
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const url = this.getAttribute('data-delete-url');
                    const title = this.getAttribute('data-delete-title') || 'Excluir Item';
                    const message = this.getAttribute('data-delete-message') || 'Tem certeza que deseja excluir este item?';
                    const confirmText = this.getAttribute('data-delete-confirm') || 'Sim, Excluir';
                    const cancelText = this.getAttribute('data-delete-cancel') || 'Cancelar';

                    AdminModals.showDeleteModal(url, title, message, confirmText, cancelText);
                });
            });
        }
    },

    /**
     * Inicializa os botões de confirmação genéricos
     */
    setupConfirmButtons: function() {
        const confirmButtons = document.querySelectorAll('[data-confirm-action]');

        if (confirmButtons.length > 0) {
            confirmButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const action = this.getAttribute('data-confirm-action');
                    const title = this.getAttribute('data-confirm-title') || 'Confirmar Ação';
                    const message = this.getAttribute('data-confirm-message') || 'Tem certeza que deseja continuar?';
                    const confirmText = this.getAttribute('data-confirm-confirm') || 'Confirmar';
                    const cancelText = this.getAttribute('data-confirm-cancel') || 'Cancelar';
                    const type = this.getAttribute('data-confirm-type') || 'warning';

                    AdminModals.showConfirmModal(action, title, message, confirmText, cancelText, type);
                });
            });
        }
    },

    /**
     * Exibe o modal de exclusão
     */
    showDeleteModal: function(url, title, message, confirmText, cancelText) {
        // Remove o modal existente, se houver
        this.removeExistingModal('deleteConfirmModal');

        // Cria o modal
        const modalHtml = `
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalTitle">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${cancelText}</button>
                            <form action="${url}" method="POST" style="display: inline;">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">${confirmText}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Exibe o modal
        const modal = document.getElementById('deleteConfirmModal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        // Remove o modal do DOM quando fechado
        modal.addEventListener('hidden.bs.modal', function() {
            modal.remove();
        });
    },

    /**
     * Exibe o modal de confirmação
     */
    showConfirmModal: function(action, title, message, confirmText, cancelText, type) {
        // Remove o modal existente, se houver
        this.removeExistingModal('confirmModal');

        // Define a classe e ícone com base no tipo
        let iconClass = 'fa-exclamation-circle text-warning';

        if (type === 'danger') {
            iconClass = 'fa-exclamation-triangle text-danger';
        } else if (type === 'success') {
            iconClass = 'fa-check-circle text-success';
        } else if (type === 'info') {
            iconClass = 'fa-info-circle text-info';
        }

        // Cria o modal
        const modalHtml = `
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalTitle"><i class="fas ${iconClass} me-2"></i> ${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${cancelText}</button>
                            <button type="button" class="btn btn-primary confirm-action">${confirmText}</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Exibe o modal
        const modal = document.getElementById('confirmModal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        // Adiciona evento ao botão de confirmação
        const confirmButton = modal.querySelector('.confirm-action');
        confirmButton.addEventListener('click', function() {
            modalInstance.hide();

            // Verifica se a ação é uma URL ou uma função
            if (typeof action === 'function') {
                action();
            } else if (typeof action === 'string' && action.trim() !== '') {
                window.location.href = action;
            }
        });

        // Remove o modal do DOM quando fechado
        modal.addEventListener('hidden.bs.modal', function() {
            modal.remove();
        });
    },

    /**
     * Remove o modal existente com o ID especificado
     */
    removeExistingModal: function(modalId) {
        const existingModal = document.getElementById(modalId);

        if (existingModal) {
            const modalInstance = bootstrap.Modal.getInstance(existingModal);

            if (modalInstance) {
                modalInstance.dispose();
            }

            existingModal.remove();
        }
    }
};

// Inicializa o sistema de modais quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    AdminModals.init();
});
