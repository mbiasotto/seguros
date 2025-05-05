/**
 * Componente de Modais
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

// Namespace para os componentes do sistema
const SeguraEssa = SeguraEssa || {};

// Componente de Modais
SeguraEssa.Modals = {
    /**
     * Inicializa o componente de modais
     */
    init: function() {
        this.setupConfirmationModals();
    },

    /**
     * Configura os modais de confirmação
     */
    setupConfirmationModals: function() {
        // Seleciona todos os botões que abrem modais de confirmação
        const confirmButtons = document.querySelectorAll('[data-confirm-modal]');

        confirmButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const modalId = this.getAttribute('data-confirm-modal');
                const targetUrl = this.getAttribute('href') || this.getAttribute('data-url');
                const modalTitle = this.getAttribute('data-modal-title') || 'Confirmar Ação';
                const modalMessage = this.getAttribute('data-modal-message') || 'Tem certeza que deseja realizar esta ação?';

                // Cria o modal dinamicamente se não existir
                let modal = document.getElementById(modalId);

                if (!modal) {
                    modal = SeguraEssa.Modals.createConfirmationModal(modalId, modalTitle, modalMessage, targetUrl);
                    document.body.appendChild(modal);

                    // Inicializa o modal do Bootstrap
                    if (typeof bootstrap !== 'undefined') {
                        new bootstrap.Modal(modal).show();
                    }
                } else {
                    // Atualiza o conteúdo do modal existente
                    const confirmBtn = modal.querySelector('.btn-confirm');
                    if (confirmBtn && targetUrl) {
                        confirmBtn.setAttribute('data-url', targetUrl);
                    }

                    // Mostra o modal
                    if (typeof bootstrap !== 'undefined') {
                        const bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    }
                }
            });
        });

        // Configura os botões de confirmação dentro dos modais
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-confirm')) {
                const url = e.target.getAttribute('data-url');
                if (url) {
                    window.location.href = url;
                }
            }
        });
    },

    /**
     * Cria um modal de confirmação dinamicamente
     * @param {string} id - ID do modal
     * @param {string} title - Título do modal
     * @param {string} message - Mensagem do modal
     * @param {string} targetUrl - URL para redirecionar após confirmação
     * @returns {HTMLElement} - Elemento do modal
     */
    createConfirmationModal: function(id, title, message, targetUrl) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = id;
        modal.tabIndex = '-1';
        modal.setAttribute('aria-labelledby', `${id}Label`);
        modal.setAttribute('aria-hidden', 'true');

        modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="${id}Label">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-confirm" data-url="${targetUrl}">Confirmar</button>
                    </div>
                </div>
            </div>
        `;

        return modal;
    }
};

// Inicializa o componente quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    SeguraEssa.Modals.init();
});