/**
 * Form Handlers para Establishments
 * Lida com máscaras e consulta de CEP
 */

$(document).ready(function() {
    // Verifica se deve pular a inicialização automática de máscaras
    if (!window.skipDefaultMasks) {
        // Inicializa as máscaras (requer jQuery Mask Plugin)
        initFormMasks();
    }

    // Inicializa a consulta de CEP
    initCepLookup();

    /**
     * Inicializa máscaras para os campos do formulário
     */
    function initFormMasks() {
        if (typeof $.fn.mask !== 'undefined') {
            $('.cnpj-mask').mask('00.000.000/0000-00');
            $('.cep-mask').mask('00000-000');

            // Máscara dinâmica para telefone
            const phoneBehavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            };

            const phoneOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(phoneBehavior.apply({}, arguments), options);
                }
            };

            $('.phone-mask, #telefone').mask(phoneBehavior, phoneOptions);
        } else {
            console.warn('jQuery Mask Plugin não está disponível. As máscaras não serão aplicadas.');
        }
    }

    /**
     * Inicializa a consulta de CEP
     */
    function initCepLookup() {
        // Campo de CEP
        const cepField = document.getElementById('cep');

        if (!cepField) {
            return;
        }

        // Adiciona evento para consultar o CEP quando o campo perder o foco
        cepField.addEventListener('blur', function() {
            // Obtém o valor do CEP
            let cep = this.value.replace(/\D/g, '');

            // Validação básica do CEP
            if (cep.length !== 8) {
                return;
            }

            // Limpa os campos de endereço
            document.getElementById('endereco').value = '';
            document.getElementById('cidade').value = '';
            if (document.getElementById('estado')) {
                document.getElementById('estado').value = '';
            }

            // Mostra indicador de carregamento
            showLoading(true);

            // Função para mostrar/esconder indicador de carregamento
            function showLoading(show) {
                const loadingIndicator = document.getElementById('cep-loading');
                if (!loadingIndicator && show) {
                    const indicator = document.createElement('div');
                    indicator.id = 'cep-loading';
                    indicator.className = 'spinner-border spinner-border-sm text-primary ms-2';
                    indicator.setAttribute('role', 'status');

                    // Insere após o campo de CEP
                    cepField.parentNode.appendChild(indicator);
                } else if (loadingIndicator && !show) {
                    loadingIndicator.remove();
                }
            }

            // Consulta a API do ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    // Esconde indicador de carregamento
                    showLoading(false);

                    // Verifica se há erro no CEP
                    if (data.erro) {
                        showError('CEP não encontrado. Verifique e tente novamente.');
                        return;
                    }

                    // Preenche os campos
                    document.getElementById('endereco').value = data.logradouro;
                    document.getElementById('cidade').value = data.localidade;

                    // Seleciona o estado no select, se existir
                    if (document.getElementById('estado')) {
                        const estadoSelect = document.getElementById('estado');
                        for (let i = 0; i < estadoSelect.options.length; i++) {
                            if (estadoSelect.options[i].value === data.uf) {
                                estadoSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                    // Foca no campo de número para continuar o preenchimento
                    if (document.getElementById('numero')) {
                        document.getElementById('numero').focus();
                    }
                })
                .catch(error => {
                    showLoading(false);
                    showError('Erro ao consultar o CEP. Tente novamente mais tarde.');
                    console.error('Erro na consulta de CEP:', error);
                });

            // Função para mostrar mensagem de erro
            function showError(message) {
                // Verifica se já existe uma mensagem de erro
                let errorElement = document.getElementById('cep-error');
                if (!errorElement) {
                    errorElement = document.createElement('div');
                    errorElement.id = 'cep-error';
                    errorElement.className = 'text-danger small mt-1';
                    cepField.parentNode.appendChild(errorElement);
                }

                // Define a mensagem de erro
                errorElement.textContent = message;

                // Remove a mensagem após 5 segundos
                setTimeout(() => {
                    if (document.getElementById('cep-error')) {
                        document.getElementById('cep-error').remove();
                    }
                }, 5000);
            }
        });
    }
});
