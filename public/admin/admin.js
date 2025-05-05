/**
 * Admin JS Principal
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

// Importa os scripts principais
document.addEventListener('DOMContentLoaded', function() {
    // Inicialização de tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip, {
            placement: 'top',
            trigger: 'hover'
        });
    });

    // Inicialização do menu mobile
    const sidebarToggle = document.querySelector('.mobile-menu-toggle button');
    const sidebarClose = document.querySelector('.sidebar-close');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.add('active');
        });
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', function() {
            sidebar.classList.remove('active');
        });
    }

    // Toggle de sidebar desktop
    window.toggleSidebar = function() {
        const body = document.body;
        body.classList.toggle('sidebar-collapsed');
    };
});
