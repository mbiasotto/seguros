/**
 * Input Masks - Segura Essa
 * Arquivo centralizado de máscaras para campos de formulário
 */
$(document).ready(function() {
    // Função para aplicar as máscaras baseadas em classes
    function aplicarMascaras() {
        // Máscaras simples
        $('.cnpj-mask, .cnpj').mask('00.000.000/0000-00');
        $('.cpf-mask, .cpf').mask('000.000.000-00');
        $('.cep-mask, #cep').mask('00000-000');
        $('.date-mask, .date').mask('00/00/0000');
        $('.money').mask('R$ #.##0,00', {reverse: true});
        $('.telefone-fixo').mask('(00) 0000-0000');
        $('.telefone-celular').mask('(00) 00000-0000');

        // Máscara para telefone com comportamento dinâmico
        var phoneBehavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        };

        var phoneOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(phoneBehavior.apply({}, arguments), options);
            }
        };

        // Aplica a máscara dinâmica para telefones
        $('.phone-mask, #telefone, input[name="telefone"]').mask(phoneBehavior, phoneOptions);
    }

    // Aplica as máscaras na inicialização da página
    aplicarMascaras();

    // Também aplica máscaras em elementos adicionados dinamicamente
    $(document).on('DOMNodeInserted', function(e) {
        if ($(e.target).find('input').length > 0) {
            aplicarMascaras();
        }
    });
});
