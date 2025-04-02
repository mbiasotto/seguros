/**
 * Utilidades para formulários - Máscaras e consulta de CEP
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

$(document).ready(function() {
    // Inicializa máscaras para telefone e CEP
    initializeMasks();

    // Inicializa a consulta de CEP
    initializeCepLookup();
});

/**
 * Inicializa as máscaras para campos comuns
 */
function initializeMasks() {
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
}

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
