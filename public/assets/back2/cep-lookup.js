/**
 * Utilitário para consulta de CEP
 * Template - Sistema de Gestão - By mbiasotto.com
 */

// Namespace para as utilidades do sistema
const SeguraEssa = SeguraEssa || {};

// Módulo de consulta de CEP
SeguraEssa.CepLookup = {
    /**
     * Inicializa o módulo de consulta de CEP
     */
    init: function() {
        this.setupCepLookup();
    },

    /**
     * Configura a consulta de CEP
     */
    setupCepLookup: function() {
        const cepInput = document.getElementById('cep');

        if (cepInput) {
            cepInput.addEventListener('blur', function() {
                // Remove caracteres não numéricos
                const cep = this.value.replace(/\D/g, '');

                if (cep.length === 8) {
                    SeguraEssa.CepLookup.fetchAddress(cep);
                }
            });
        }
    },

    /**
     * Busca o endereço a partir do CEP
     * @param {string} cep - CEP sem formatação
     */
    fetchAddress: function(cep) {
        // Mostra indicador de carregamento
        this.showLoading(true);

        // Faz a requisição para a API ViaCEP
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                this.fillAddressFields(data);
                this.showLoading(false);
            })
            .catch(error => {
                console.error('Erro ao buscar CEP:', error);
                this.showLoading(false);
            });
    },

    /**
     * Preenche os campos de endereço com os dados retornados
     * @param {Object} data - Dados do endereço
     */
    fillAddressFields: function(data) {
        if (!data.erro) {
            // Preenche os campos de endereço
            const enderecoInput = document.getElementById('endereco');
            const cidadeInput = document.getElementById('cidade');
            const estadoSelect = document.getElementById('estado');

            if (enderecoInput) {
                enderecoInput.value = data.logradouro;
            }

            if (cidadeInput) {
                cidadeInput.value = data.localidade;
            }

            if (estadoSelect) {
                // Seleciona o estado no select
                const options = estadoSelect.options;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === data.uf) {
                        estadoSelect.selectedIndex = i;
                        break;
                    }
                }
            }

            // Foca no campo de número
            const numeroInput = document.getElementById('numero');
            if (numeroInput) {
                numeroInput.focus();
            }
        }
    },

    /**
     * Mostra ou esconde o indicador de carregamento
     * @param {boolean} show - Indica se deve mostrar ou esconder
     */
    showLoading: function(show) {
        const cepInput = document.getElementById('cep');

        if (cepInput) {
            if (show) {
                cepInput.classList.add('loading');
            } else {
                cepInput.classList.remove('loading');
            }
        }
    }
};

// Inicializa o módulo quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    SeguraEssa.CepLookup.init();
});
