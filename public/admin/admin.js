/**
 * Admin - JS Principal Consolidado
 * Template - Sistema de Gestão - By mbiasotto.com
 */

// Verificar se o jQuery está carregado
if (typeof jQuery === 'undefined') {
    console.error('Admin.js: jQuery is not loaded');
} else {
    // Inicialização do Admin JS
    $(document).ready(function() {

        // Inicializar tooltip
        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Inicializar popovers
        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Popover !== 'undefined') {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        }

        // Inicialização dos filtros para todas as páginas de listagem
        function initFilterToggle() {
            // Verifica se a página tem um container de filtros
            if ($('.filter-container').length > 0) {
                // Se já existe um botão de toggle, não faz nada
                if ($('.filter-toggle-btn').length > 0) {
                    $('.filter-toggle-btn').on('click', function() {
                        $('.filter-collapse').toggleClass('show');
                        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
                    });
                } else {
                    // Adiciona classe para controle do display
                    $('.filter-container').addClass('filter-collapse d-md-block');

                    // Adiciona o botão de toggle antes do container de filtros
                    $('<div class="d-md-none w-100 mb-3"><button class="btn btn-secondary w-100 filter-toggle-btn d-flex align-items-center justify-content-between"><span>Filtros</span><i class="fas fa-chevron-down"></i></button></div>')
                        .insertBefore('.filter-container');

                    // Adiciona o evento de click
                    $('.filter-toggle-btn').on('click', function() {
                        $('.filter-collapse').toggleClass('show');
                        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
                    });
                }
            }
        }

        // Inicializa os filtros para todas as páginas
        initFilterToggle();

        // Função para abrir o sidebar
        function openSidebar() {
            $('#sidebar').addClass('show');
            $('#sidebar-overlay').addClass('show');
            $('body').addClass('sidebar-open');
        }

        // Função para fechar o sidebar
        function closeSidebar() {
            $('#sidebar').removeClass('show');
            $('#sidebar-overlay').removeClass('show');
            $('body').removeClass('sidebar-open');
        }

        // Toggle para a sidebar em dispositivos móveis
        $('.mobile-toggle-btn').on('click', function(e) {
            e.stopPropagation();
            if ($('#sidebar').hasClass('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        // Fechar sidebar ao clicar no overlay
        $('#sidebar-overlay').on('click', function() {
            closeSidebar();
        });

        // Prevenir que cliques dentro do sidebar o fechem
        $('#sidebar').on('click', function(e) {
            e.stopPropagation();
        });

        // Fechar sidebar ao clicar fora (no documento)
        $(document).on('click', function(e) {
            if ($('#sidebar').hasClass('show') &&
                !$(e.target).closest('#sidebar').length &&
                !$(e.target).closest('.mobile-toggle-btn').length) {
                closeSidebar();
            }
        });

        // Fechar sidebar ao clicar em links do menu (apenas em mobile)
        if (window.innerWidth < 768) {
            $('#sidebar .nav-link').on('click', function() {
                closeSidebar();
            });
        }
    });
}
