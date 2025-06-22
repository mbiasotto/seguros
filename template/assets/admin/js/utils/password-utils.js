/**
 * Utilitários para gerenciamento de campos de senha
 * Template - Sistema de Gestão - By mbiasotto.com
 */

const PasswordUtils = {
    /**
     * Inicializa os utilitários de senha
     */
    init: function() {
        this.initializePasswordToggles();
        this.initializePasswordValidation();
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
    }
};

// Inicializa quando o documento estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    PasswordUtils.init();
});
