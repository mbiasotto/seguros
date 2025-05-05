/**
 * Componente de Sidebar (Menu Lateral)
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

// Namespace para os componentes do sistema
const SeguraEssa = SeguraEssa || {};

// Componente de Sidebar
SeguraEssa.Sidebar = {
    /**
     * Inicializa o componente de sidebar
     */
    init: function() {
        this.setupToggle();
        this.setupMobileClose();
    },

    /**
     * Configura o botão de toggle do sidebar
     */
    setupToggle: function() {
        const sidebarToggle = document.querySelector('[data-toggle="sidebar"]');
        const sidebar = document.getElementById('sidebar');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }
    },

    /**
     * Configura o fechamento do sidebar em dispositivos móveis
     * ao clicar fora do menu
     */
    setupMobileClose: function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.querySelector('[data-toggle="sidebar"]');

        if (sidebar) {
            document.addEventListener('click', function(event) {
                const isMobile = window.innerWidth < 768;
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = sidebarToggle && sidebarToggle.contains(event.target);

                if (isMobile && !isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        }
    },

    /**
     * Alterna a visibilidade do sidebar
     */
    toggle: function() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
    }
};

// Inicializa o componente quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    SeguraEssa.Sidebar.init();
});