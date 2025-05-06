/**
 * Admin JavaScript Principal
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 *
 * Este arquivo inicializa todos os componentes JavaScript necessários para o painel administrativo
 */

// Inicialização do sistema de administração
const AdminSystem = {
    /**
     * Inicializa o sistema administrativo
     */
    init: function() {
        // Inicializa os componentes básicos
        this.setupComponents();

        // Inicializa funcionalidades específicas por página, com base na rota atual
        this.setupPageSpecific();

        // Inicializa funcionalidades comuns em todas as páginas
        this.setupCommon();
    },

    /**
     * Inicializa componentes básicos do sistema
     */
    setupComponents: function() {
        // Os componentes já se auto-inicializam quando o DOM é carregado
        // Essa função serve para inicialização manual, se necessário
    },

    /**
     * Inicializa funcionalidades específicas para páginas diferentes
     */
    setupPageSpecific: function() {
        // Identifica a rota atual baseada no path ou em algum data-attribute
        const currentPath = window.location.pathname;

        // Dashboard
        if (currentPath.includes('/admin/dashboard') || currentPath === '/admin') {
            this.initDashboard();
        }

        // Usuários
        if (currentPath.includes('/admin/users')) {
            this.initUsers();
        }

        // Vendedores
        if (currentPath.includes('/admin/vendors')) {
            this.initVendors();
        }

        // Estabelecimentos
        if (currentPath.includes('/admin/establishments')) {
            this.initEstablishments();
        }

        // QR Codes
        if (currentPath.includes('/admin/qr-codes')) {
            this.initQrCodes();
        }

        // Documentos
        if (currentPath.includes('/admin/documents')) {
            this.initDocuments();
        }
    },

    /**
     * Inicializa funcionalidades comuns a todas as páginas
     */
    setupCommon: function() {
        // Inicializa tooltips do Bootstrap
        this.initTooltips();

        // Inicializa máscaras de formulários
        this.initFormMasks();

        // Inicializa alertas automáticos
        this.initAutoAlerts();

        // Inicializa o comportamento do menu mobile
        this.initMobileMenu();

        // Inicializa o comportamento do sidebar toggle
        this.initSidebarToggle();
    },

    /**
     * Inicializa tooltips do Bootstrap para todos os elementos que precisam
     */
    initTooltips: function() {
        // Remover tooltips existentes para evitar duplicação
        $('[data-bs-original-title]').tooltip('dispose');
        $('.tooltip').remove();

        // Tooltips para elementos que usam data-bs-toggle (padrão Bootstrap)
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Tooltips para todos os botões de ação que possuem atributo title ou data-tooltip
        $('.action-buttons .btn, .action-btn, .btn-action, [data-tooltip]').each(function() {
            const title = $(this).attr('title') || $(this).data('tooltip');
            if (title) {
                $(this).tooltip({
                    title: title,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                    boundary: 'window',
                    animation: true
                });

                // Remover o atributo title para evitar tooltip nativo do navegador
                if ($(this).attr('title')) {
                    $(this).attr('data-original-title', $(this).attr('title')).removeAttr('title');
                }
            }
        });

        // Atribuir tooltips a ícones dentro de botões que não têm título próprio
        $('button i, a i').each(function() {
            const $parent = $(this).parent();
            if (!$parent.attr('title') && !$parent.data('tooltip') && !$parent.data('original-title') && !$parent.data('bs-toggle')) {
                const iconClass = $(this).attr('class');

                // Atribuir tooltips baseados na classe do ícone
                if (iconClass) {
                    let tooltipText = '';

                    if (iconClass.includes('fa-edit') || iconClass.includes('fa-pencil')) {
                        tooltipText = 'Editar';
                    } else if (iconClass.includes('fa-trash')) {
                        tooltipText = 'Excluir';
                    } else if (iconClass.includes('fa-eye')) {
                        tooltipText = 'Visualizar';
                    } else if (iconClass.includes('fa-plus')) {
                        tooltipText = 'Adicionar';
                    } else if (iconClass.includes('fa-download')) {
                        tooltipText = 'Baixar';
                    } else if (iconClass.includes('fa-upload')) {
                        tooltipText = 'Enviar';
                    } else if (iconClass.includes('fa-check')) {
                        tooltipText = 'Aprovar';
                    } else if (iconClass.includes('fa-times')) {
                        tooltipText = 'Rejeitar';
                    } else if (iconClass.includes('fa-history')) {
                        tooltipText = 'Histórico';
                    } else if (iconClass.includes('fa-ban')) {
                        tooltipText = 'Bloquear';
                    } else if (iconClass.includes('fa-lock')) {
                        tooltipText = 'Restrito';
                    } else if (iconClass.includes('fa-unlock')) {
                        tooltipText = 'Liberado';
                    }

                    if (tooltipText) {
                        $parent.attr('data-tooltip', tooltipText);
                        $parent.tooltip({
                            title: tooltipText,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body',
                            boundary: 'window',
                            animation: true
                        });
                    }
                }
            }
        });

        // Fechar tooltips quando o elemento é clicado
        $('[data-tooltip], [data-bs-toggle="tooltip"], [data-original-title]').on('click', function() {
            $(this).tooltip('hide');
        });

        // Garantir que tooltips funcionem mesmo após carregamento dinâmico de conteúdo
        $('body').on('mouseenter', '.action-buttons .btn, .action-btn, .btn-action', function() {
            const $this = $(this);
            if (!$this.data('bs-tooltip') && ($this.attr('title') || $this.data('tooltip') || $this.attr('data-original-title'))) {
                const title = $this.attr('title') || $this.data('tooltip') || $this.attr('data-original-title');
                $this.tooltip({
                    title: title,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                    boundary: 'window',
                    animation: true
                }).tooltip('show');
            }
        });
    },

    /**
     * Inicializa máscaras de formulários (requer jQuery Mask Plugin)
     */
    initFormMasks: function() {
        if (typeof $.fn.mask !== 'undefined') {
            $('.cnpj-mask').mask('00.000.000/0000-00');
            $('.cpf-mask').mask('000.000.000-00');
            $('.cep-mask').mask('00000-000');
            $('.date-mask').mask('00/00/0000');

            // Máscara dinâmica para telefone
            const phoneBehavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            };

            const phoneOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(phoneBehavior.apply({}, arguments), options);
                }
            };

            $('.phone-mask').mask(phoneBehavior, phoneOptions);
        }
    },

    /**
     * Inicializa alertas automáticos com tempo de expiração
     */
    initAutoAlerts: function() {
        // Usar jQuery para selecionar e gerenciar alertas automáticos
        const $autoAlerts = $('.alert.alert-dismissible[data-auto-dismiss]');

        if ($autoAlerts.length > 0) {
            $autoAlerts.each(function() {
                const $alert = $(this);
                const timeout = parseInt($alert.data('auto-dismiss')) || 5000;

                setTimeout(function() {
                    $alert.fadeOut('slow', function() {
                        $alert.remove();
                    });
                }, timeout);
            });
        }
    },

    /**
     * Inicializa o comportamento do menu mobile
     */
    initMobileMenu: function() {
        // Detecta se é dispositivo móvel
        const isMobile = window.innerWidth < 768;

        // Botão toggle para menu mobile
        $('.mobile-menu-toggle button').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#sidebar').toggleClass('show');
        });

        // Fechar menu quando o botão de fechar for clicado
        $('.sidebar-close').on('click', function(e) {
            e.preventDefault();
            $('#sidebar').removeClass('show');
        });

        // Fechar menu quando clicar fora dele em dispositivos móveis
        $(document).on('click', function(e) {
            if (isMobile) {
                const $sidebar = $('#sidebar');
                const $toggleBtn = $('.mobile-menu-toggle button');

                if ($sidebar.hasClass('show') &&
                    !$sidebar[0].contains(e.target) &&
                    !$toggleBtn[0].contains(e.target)) {
                    $sidebar.removeClass('show');
                }
            }
        });

        // Fechar menu quando um item for clicado (apenas em mobile)
        if (isMobile) {
            $('#sidebar .nav-link').on('click', function() {
                $('#sidebar').removeClass('show');
            });
        }

        // Atualizar a detecção de dispositivo móvel quando a janela é redimensionada
        $(window).on('resize', function() {
            const newIsMobile = window.innerWidth < 768;
            if (newIsMobile !== isMobile) {
                location.reload(); // Recarrega a página para ajustar corretamente o layout
            }
        });
    },

    /**
     * Inicializa o comportamento de alternância da barra lateral
     */
    initSidebarToggle: function() {
        // Função para alternar a largura da sidebar no desktop
        window.toggleSidebar = function() {
            const $sidebar = $('#sidebar');
            $sidebar.toggleClass('lg:w-64');
            $sidebar.toggleClass('lg:w-20');

            // Alternar a visibilidade dos textos dos links
            if ($sidebar.hasClass('lg:w-20')) {
                $sidebar.find('.nav-link span').addClass('lg:hidden');
                $sidebar.find('.nav-link').addClass('lg:justify-center');
                $sidebar.find('.nav-link i').addClass('lg:mr-0');
            } else {
                $sidebar.find('.nav-link span').removeClass('lg:hidden');
                $sidebar.find('.nav-link').removeClass('lg:justify-center');
                $sidebar.find('.nav-link i').removeClass('lg:mr-0');
            }
        };

        // Atribuir evento ao botão de toggle da sidebar no desktop
        $('[onclick="toggleSidebar()"]').on('click', function(e) {
            e.preventDefault();
            toggleSidebar();
        });
    },

    /**
     * Inicializa funcionalidades específicas do Dashboard
     */
    initDashboard: function() {
        // O AdminDashboard já se inicializa automaticamente via $(document).ready
    },

    /**
     * Inicializa funcionalidades específicas da página de Usuários
     */
    initUsers: function() {
        // O AdminUsers já se inicializa automaticamente via $(document).ready
    },

    /**
     * Inicializa funcionalidades específicas da página de Vendedores
     */
    initVendors: function() {
        // O AdminVendors já se inicializa automaticamente via $(document).ready
    },

    /**
     * Inicializa funcionalidades específicas da página de Estabelecimentos
     */
    initEstablishments: function() {
        // O AdminEstablishments já se inicializa automaticamente via $(document).ready
    },

    /**
     * Inicializa funcionalidades específicas da página de QR Codes
     */
    initQrCodes: function() {
        // O AdminQrCodes já se inicializa automaticamente via $(document).ready
    },

    /**
     * Inicializa funcionalidades específicas da página de Documentos
     */
    initDocuments: function() {
        // O AdminDocuments já se inicializa automaticamente via $(document).ready
    }
};

// Inicializa o sistema quando o DOM estiver pronto
$(document).ready(function() {
    AdminSystem.init();

    // Reinicializar tooltips quando uma página é carregada via AJAX ou quando elementos são adicionados dinamicamente
    $(document).ajaxComplete(function() {
        setTimeout(function() {
            AdminSystem.initTooltips();
        }, 100);
    });

    // Inicializar tooltips do Bootstrap em todo o painel admin
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            boundary: document.body // Garante que o tooltip não seja cortado
        });
    });

    // Delegação de eventos para botões de exclusão (se esta lógica estiver aqui)
    $(document).on('click', '[data-delete-url]', function () {
        // ... manter a lógica do modal de exclusão aqui, se aplicável ...
    });
});

// Função para alternar sidebar (se estiver aqui)
function toggleSidebar() {
    // ... manter a lógica de toggle aqui ...
}
