/**
 * Utilidades para formulários - Consulta de CEP
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

$(document).ready(function() {
    // Inicializa a consulta de CEP
    initializeCepLookup();
});

/**
 * Inicializa o autopreenchimento pelo CEP via ViaCEP API
 */
function initializeCepLookup() {
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
}
