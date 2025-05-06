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
        const togglePasswordButtons = document.querySelectorAll('.password-toggle-icon');

        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const passwordField = this.closest('.password-wrapper').querySelector('input');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        });
    },

    /**
     * Inicializa a validação visual de requisitos de senha
     */
    initializePasswordValidation: function() {
        const passwordInput = document.getElementById('password');

        if (!passwordInput) return;

        const requirements = [
            { regex: /.{8,}/, index: 0 },       // Mínimo 8 caracteres
            { regex: /[A-Z]/, index: 1 },       // Pelo menos uma letra maiúscula
            { regex: /[a-z]/, index: 2 },       // Pelo menos uma letra minúscula
            { regex: /[0-9]/, index: 3 },       // Pelo menos um número
            { regex: /[@$!%*#?&]/, index: 4 }   // Pelo menos um caractere especial
        ];

        passwordInput.addEventListener('input', function() {
            const value = this.value;
            const requirementItems = document.querySelectorAll('.password-requirements ul li');

            if (requirementItems.length === 0) return;

            requirements.forEach(item => {
                const isValid = item.regex.test(value);
                const requirementItem = requirementItems[item.index];

                if (isValid) {
                    requirementItem.classList.add('text-success');
                    requirementItem.classList.remove('text-muted');

                    // Verifica se já tem o ícone de check e adiciona se não tiver
                    if (!requirementItem.innerHTML.includes('fa-check-circle')) {
                        requirementItem.innerHTML = '<i class="fas fa-check-circle me-1"></i>' +
                            requirementItem.innerHTML.replace(/<i class="fas fa-[^"]+"><\/i>\s*/, '');
                    }
                } else {
                    requirementItem.classList.remove('text-success');
                    requirementItem.classList.add('text-muted');

                    // Remove o ícone de check se existir
                    requirementItem.innerHTML = requirementItem.innerHTML.replace(/<i class="fas fa-[^"]+"><\/i>\s*/, '');
                }
            });
        });
    },

    /**
     * Inicializa efeitos hover para botões
     */
    initializeButtonHoverEffects: function() {
        // Para botões de autenticação principais
        const submitButtons = document.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(button => {
            if (!button.classList.contains('btn-auth') && !button.classList.contains('btn-secondary')) {
                button.addEventListener('mouseover', function() {
                    this.style.backgroundColor = '#2A48A7';
                    this.style.borderColor = '#2A48A7';
                    this.style.boxShadow = '0 4px 10px rgba(29, 64, 174, 0.15)';
                });
                button.addEventListener('mouseout', function() {
                    this.style.backgroundColor = '#1D40AE';
                    this.style.borderColor = '#1D40AE';
                    this.style.boxShadow = 'none';
                });
            }
        });
    }
};

// Inicializa quando o documento estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    AuthUtils.init();
});
