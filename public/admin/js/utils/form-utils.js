/**
 * Utilidades para formulários - Máscaras e consulta de CEP
 * Template - Sistema de Gestão - By mbiasotto.com
 * Versão modular e organizada
 */

// Namespace para as utilidades do sistema
const SeguraEssa = {
    // Módulo de formulários
    Forms: {
        /**
         * Inicializa todas as funcionalidades de formulários
         */
        init: function() {
            this.initializeMasks();
            this.initializeCepLookup();
            this.initializeValidation();
        },

        /**
         * Inicializa as máscaras para campos comuns
         */
        initializeMasks: function() {
            // Máscara para telefone (formato: (00) 00000-0000)
            if ($('#telefone').length) {
                $('#telefone').mask('(00) 00000-0000');
            }

            // Máscara para telefone fixo (formato: (00) 0000-0000)
            if ($('.telefone-fixo').length) {
                $('.telefone-fixo').mask('(00) 0000-0000');
            }

            // Máscara para telefone celular (formato: (00) 00000-0000)
            if ($('.telefone-celular').length) {
                $('.telefone-celular').mask('(00) 00000-0000');
            }

            // Máscara para CEP (formato: 00000-000)
            if ($('#cep').length) {
                $('#cep').mask('00000-000');
            }

            // Máscara para CPF (formato: 000.000.000-00)
            if ($('.cpf').length) {
                $('.cpf').mask('000.000.000-00');
            }

            // Máscara para CNPJ (formato: 00.000.000/0000-00)
            if ($('.cnpj').length) {
                $('.cnpj').mask('00.000.000/0000-00');
            }

            // Máscara para dinheiro (formato: R$ 0.000,00)
            if ($('.money').length) {
                $('.money').mask('R$ #.##0,00', {reverse: true});
            }

            // Máscara para data (formato: 00/00/0000)
            if ($('.date').length) {
                $('.date').mask('00/00/0000');
            }
        },

        /**
         * Inicializa o autopreenchimento pelo CEP via ViaCEP API
         */
        initializeCepLookup: function() {
            if ($('#cep').length) {
                $('#cep').blur(function() {
                    const cep = $(this).val().replace(/\D/g, '');

                    if (cep.length !== 8) return;

                    // Mostra loader ou mensagem de carregamento
                    $(this).addClass('is-loading');

                    $.ajax({
                        url: `https://viacep.com.br/ws/${cep}/json/`,
                        dataType: 'json',
                        success: function(data) {
                            // Remove loader
                            $('#cep').removeClass('is-loading');

                            if (!data.erro) {
                                // Preenche os campos com os dados retornados
                                $('#endereco').val(data.logradouro);
                                $('#cidade').val(data.localidade);
                                $('#estado').val(data.uf).trigger('change');

                                // Se tiver campos separados para bairro, complemento, etc
                                if ($('#bairro').length) {
                                    $('#bairro').val(data.bairro);
                                }

                                if ($('#complemento').length) {
                                    $('#complemento').val(data.complemento);
                                }
                            }
                        },
                        error: function() {
                            // Remove loader
                            $('#cep').removeClass('is-loading');
                            alert('Erro ao consultar o CEP. Tente novamente.');
                        }
                    });
                });
            }
        },

        /**
         * Inicializa a validação de formulários
         */
        initializeValidation: function() {
            // Exemplo de validação de formulário usando Bootstrap
            if ($('.needs-validation').length) {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                const forms = document.querySelectorAll('.needs-validation');

                // Loop over them and prevent submission
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        form.classList.add('was-validated');
                    }, false);
                });
            }
        }
    },

    // Módulo de UI
    UI: {
        /**
         * Inicializa funcionalidades da interface
         */
        init: function() {
            this.initializeTooltips();
            this.initializePopovers();
        },

        /**
         * Inicializa tooltips do Bootstrap
         */
        initializeTooltips: function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        },

        /**
         * Inicializa popovers do Bootstrap
         */
        initializePopovers: function() {
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
        }
    }
};

// Inicializa os módulos quando o documento estiver pronto
$(document).ready(function() {
    SeguraEssa.Forms.init();
    SeguraEssa.UI.init();
});
