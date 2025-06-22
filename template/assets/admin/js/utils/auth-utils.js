/**
 * Utilitários para páginas de autenticação
 * Template - Sistema de Gestão - By mbiasotto.com
 */

const AuthUtils = {
    /**
     * Inicializa os utilitários de autenticação
     */
    init: function() {
        this.initializePasswordToggles();
        this.initializePasswordValidation();
        this.initializeButtonHoverEffects();
    },

    /**
     * Inicializa os toggles para mostrar/esconder senha
     */
    initializePasswordToggles: function() {
        // Usando jQuery para selecionar os botões de toggle
        $('.password-toggle-icon').on('click', function() {
            // Encontra o campo de senha mais próximo dentro do wrapper
            const passwordField = $(this).closest('.password-wrapper').find('input');

            // Alterna o tipo do campo entre password e text
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);

            // Alterna as classes de ícone
            $(this).toggleClass('fa-eye-slash fa-eye');
        });
    },

    /**
     * Inicializa a validação visual de requisitos de senha
     */
    initializePasswordValidation: function() {
        // Usando jQuery para selecionar o campo de senha
        const $passwordInput = $('#password');

        if ($passwordInput.length === 0) return;

        const requirements = [
            { regex: /.{8,}/, index: 0 },       // Mínimo 8 caracteres
            { regex: /[A-Z]/, index: 1 },       // Pelo menos uma letra maiúscula
            { regex: /[a-z]/, index: 2 },       // Pelo menos uma letra minúscula
            { regex: /[0-9]/, index: 3 },       // Pelo menos um número
            { regex: /[@$!%*#?&]/, index: 4 }   // Pelo menos um caractere especial
        ];

        $passwordInput.on('input', function() {
            const value = $(this).val();
            const $requirementItems = $('.password-requirements ul li');

            if ($requirementItems.length === 0) return;

            requirements.forEach(item => {
                const isValid = item.regex.test(value);
                const $requirementItem = $requirementItems.eq(item.index);

                if (isValid) {
                    $requirementItem.addClass('text-success').removeClass('text-muted');

                    // Verifica se já tem o ícone de check e adiciona se não tiver
                    if (!$requirementItem.html().includes('fa-check-circle')) {
                        $requirementItem.html('<i class="fas fa-check-circle me-1"></i>' +
                            $requirementItem.html().replace(/<i class="fas fa-[^"]+"><\/i>\s*/, ''));
                    }
                } else {
                    $requirementItem.removeClass('text-success').addClass('text-muted');

                    // Remove o ícone de check se existir
                    $requirementItem.html($requirementItem.html().replace(/<i class="fas fa-[^"]+"><\/i>\s*/, ''));
                }
            });
        });
    },

    /**
     * Inicializa efeitos hover para botões
     */
    initializeButtonHoverEffects: function() {
        // Para botões de autenticação principais usando jQuery
        $('button[type="submit"]').each(function() {
            if (!$(this).hasClass('btn-auth') && !$(this).hasClass('btn-secondary')) {
                $(this).hover(
                    function() {
                        $(this).css({
                            'background-color': '#2A48A7',
                            'border-color': '#2A48A7',
                            'box-shadow': '0 4px 10px rgba(29, 64, 174, 0.15)'
                        });
                    },
                    function() {
                        $(this).css({
                            'background-color': '#1D40AE',
                            'border-color': '#1D40AE',
                            'box-shadow': 'none'
                        });
                    }
                );
            }
        });
    }
};

// Usando jQuery para inicializar quando o documento estiver pronto
$(document).ready(function() {
    // Verifica se jQuery está carregado
    if (typeof $ === 'undefined') {
        console.error('jQuery não está carregado. A funcionalidade de toggle de senha pode não funcionar corretamente.');
        return;
    }

    AuthUtils.init();
});
