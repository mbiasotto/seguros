/**
 * Modal JS
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 *
 * Este script gerencia a criação e comportamento de modais modernos reutilizáveis em todo o sistema.
 */

class ModernModal {
    /**
     * Inicializa o sistema de modais
     */
    static init() {
        // Inicializa os modais Bootstrap
        document.querySelectorAll('.modal').forEach(modalElement => {
            new bootstrap.Modal(modalElement);
        });

        // Adiciona classes modernas aos modais existentes
        document.querySelectorAll('.modal').forEach(modal => {
            if (!modal.classList.contains('modal-modern')) {
                modal.classList.add('modal-modern');
            }
        });

        // Inicializa os event listeners para botões de excluir e outros que usam data-attributes
        this.initDeleteButtons();
        this.initConfirmButtons();
    }

    /**
     * Inicializa os botões de exclusão
     */
    static initDeleteButtons() {
        document.querySelectorAll('[data-delete-url]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const url = this.getAttribute('data-delete-url');
                const title = this.getAttribute('data-delete-title') || 'Excluir item';
                const message = this.getAttribute('data-delete-message') || 'Tem certeza que deseja excluir este item?';
                const confirmText = this.getAttribute('data-delete-confirm') || 'Excluir';
                const cancelText = this.getAttribute('data-delete-cancel') || 'Cancelar';

                ModernModal.confirmDelete(url, title, message, confirmText, cancelText);
            });
        });
    }

    /**
     * Inicializa os botões de confirmação genéricos
     */
    static initConfirmButtons() {
        document.querySelectorAll('[data-confirm-action]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const action = this.getAttribute('data-confirm-action');
                const title = this.getAttribute('data-confirm-title') || 'Confirmar ação';
                const message = this.getAttribute('data-confirm-message') || 'Tem certeza que deseja continuar?';
                const confirmText = this.getAttribute('data-confirm-confirm') || 'Confirmar';
                const cancelText = this.getAttribute('data-confirm-cancel') || 'Cancelar';
                const type = this.getAttribute('data-confirm-type') || 'warning';

                ModernModal.confirm(action, title, message, confirmText, cancelText, type);
            });
        });
    }

    /**
     * Cria um modal de exclusão
     */
    static confirmDelete(url, title, message, confirmText, cancelText) {
        // Verifica se já existe um modal temporário e remove-o
        const existingModal = document.getElementById('deleteConfirmModal');
        if (existingModal) {
            const modalBS = bootstrap.Modal.getInstance(existingModal);
            if (modalBS) modalBS.dispose();
            existingModal.remove();
        }

        // Cria o modal
        const modal = document.createElement('div');
        modal.className = 'modal fade modal-modern modal-confirm';
        modal.id = 'deleteConfirmModal';
        modal.setAttribute('tabindex', '-1');
        modal.setAttribute('aria-hidden', 'true');

        // Conteúdo do modal
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="icon-container danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 class="confirm-title">${title}</h4>
                        <p class="confirm-message">${message}</p>
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
        `;

        document.body.appendChild(modal);

        // Inicializa o modal Bootstrap
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        // Remover o modal do DOM quando ele for fechado
        modal.addEventListener('hidden.bs.modal', () => {
            modal.remove();
        });
    }

    /**
     * Cria um modal de confirmação genérico
     */
    static confirm(action, title, message, confirmText, cancelText, type = 'warning') {
        // Verifica se já existe um modal temporário e remove-o
        const existingModal = document.getElementById('dynamicConfirmModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Cria o modal
        const modal = document.createElement('div');
        modal.className = 'modal fade modal-modern modal-confirm';
        modal.id = 'dynamicConfirmModal';
        modal.setAttribute('tabindex', '-1');
        modal.setAttribute('aria-hidden', 'true');

        // Conteúdo do modal
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="icon-container ${type}">
                            <i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : type === 'success' ? 'check' : 'exclamation-circle'}"></i>
                        </div>
                        <h4 class="confirm-title">${title}</h4>
                        <p class="confirm-message">${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">${cancelText}</button>
                        <button type="button" class="btn btn-confirm">${confirmText}</button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Inicializa o modal Bootstrap
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        // Adiciona event listener ao botão de confirmação
        const confirmButton = modal.querySelector('.btn-confirm');
        confirmButton.addEventListener('click', () => {
            modalInstance.hide();

            // Se a ação for uma função, execute-a, caso contrário, redirecione
            if (typeof action === 'function') {
                action();
            } else if (typeof action === 'string' && action.trim() !== '') {
                window.location.href = action;
            }
        });

        // Remover o modal do DOM quando ele for fechado
        modal.addEventListener('hidden.bs.modal', () => {
            modal.remove();
        });
    }

    /**
     * Cria um modal básico com conteúdo personalizado
     */
    static create(options = {}) {
        const {
            id = 'dynamicModal',
            title = '',
            content = '',
            size = '', // 'modal-sm', 'modal-lg' ou 'modal-xl'
            closeButton = true,
            buttons = [],
            onShow = null,
            onHide = null
        } = options;

        // Verifica se já existe um modal com este ID e remove-o
        const existingModal = document.getElementById(id);
        if (existingModal) {
            existingModal.remove();
        }

        // Cria o modal
        const modal = document.createElement('div');
        modal.className = 'modal fade modal-modern';
        modal.id = id;
        modal.setAttribute('tabindex', '-1');
        modal.setAttribute('aria-hidden', 'true');

        // Conteúdo do modal
        let buttonHtml = '';
        if (buttons.length > 0) {
            buttonHtml = buttons.map(button => {
                return `<button type="button" class="btn ${button.class || 'btn-secondary'}"
                    id="${button.id || ''}" ${button.dismiss ? 'data-bs-dismiss="modal"' : ''}>${button.text}</button>`;
            }).join('');
        }

        modal.innerHTML = `
            <div class="modal-dialog ${size}">
                <div class="modal-content">
                    ${title ? `
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                            ${closeButton ? '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>' : ''}
                        </div>
                    ` : ''}
                    <div class="modal-body">
                        ${content}
                    </div>
                    ${buttonHtml ? `<div class="modal-footer">${buttonHtml}</div>` : ''}
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Inicializa o modal Bootstrap
        const modalInstance = new bootstrap.Modal(modal);

        // Adiciona event listeners para os botões
        buttons.forEach(button => {
            if (button.id && button.callback) {
                const buttonEl = modal.querySelector(`#${button.id}`);
                if (buttonEl) {
                    buttonEl.addEventListener('click', (e) => {
                        button.callback(e, modalInstance);
                    });
                }
            }
        });

        // Callback quando o modal é exibido
        if (onShow) {
            modal.addEventListener('shown.bs.modal', onShow);
        }

        // Callback quando o modal é escondido
        if (onHide) {
            modal.addEventListener('hidden.bs.modal', onHide);
        }

        // Remover o modal do DOM quando ele for fechado se for temporário
        if (options.temporary !== false) {
            modal.addEventListener('hidden.bs.modal', () => {
                modal.remove();
            });
        }

        return {
            modal: modal,
            instance: modalInstance,
            show: () => modalInstance.show(),
            hide: () => modalInstance.hide()
        };
    }
}

// Inicializa os modais quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    ModernModal.init();
});
