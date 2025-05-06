/**
 * Sidebar Component JS
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

const AdminSidebar = {
    /**
     * Inicializa o componente de sidebar
     */
    init: function() {
        this.setupMobileToggle();
        this.setupClickOutside();
        this.setupResize();
    },

    /**
     * Configura o botão de toggle da sidebar em dispositivos móveis
     */
    setupMobileToggle: function() {
        const toggleBtns = document.querySelectorAll('[data-toggle="sidebar"], [onclick*="toggleSidebar()"]');
        const sidebar = document.getElementById('sidebar');

        if (sidebar && toggleBtns.length > 0) {
            toggleBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('show');
                });
            });
        }
    },

    /**
     * Configura o fechamento da sidebar ao clicar fora dela em dispositivos móveis
     */
    setupClickOutside: function() {
        const sidebar = document.getElementById('sidebar');

        if (sidebar) {
            document.addEventListener('click', function(e) {
                // Verifica se é um dispositivo móvel
                if (window.innerWidth < 768) {
                    // Verifica se o clique foi fora da sidebar e não foi em um botão de toggle
                    const isClickInsideSidebar = sidebar.contains(e.target);
                    const isToggleButton = e.target.hasAttribute('data-toggle') &&
                                          e.target.getAttribute('data-toggle') === 'sidebar';
                    const isToggleButtonIcon = e.target.closest('[data-toggle="sidebar"]');

                    if (!isClickInsideSidebar && !isToggleButton && !isToggleButtonIcon && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        }
    },

    /**
     * Configura o comportamento da sidebar em caso de redimensionamento da janela
     */
    setupResize: function() {
        const sidebar = document.getElementById('sidebar');

        if (sidebar) {
            window.addEventListener('resize', function() {
                // Se a largura da janela é maior que 768px (desktop), remove a classe 'show'
                if (window.innerWidth >= 768 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        }
    },

    /**
     * Alterna a visibilidade da sidebar
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
    AdminSidebar.init();
});

// Função global para alternar a sidebar (para uso em atributos onclick)
function toggleSidebar() {
    AdminSidebar.toggle();
}
