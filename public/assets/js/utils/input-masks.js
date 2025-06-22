/**
 * Máscaras de input
 * Sistema Admin
 */

$(document).ready(function() {
    // Máscara de CNPJ
    $('.cnpj-mask').mask('00.000.000/0000-00', {
        reverse: false,
        placeholder: '00.000.000/0000-00'
    });

    // Máscara de CPF
    $('.cpf-mask').mask('000.000.000-00', {
        reverse: false,
        placeholder: '000.000.000-00'
    });

    // Máscara de telefone
    $('.phone-mask').mask('(00) 00000-0000', {
        reverse: false,
        placeholder: '(00) 00000-0000'
    });

    // Máscara de CEP
    $('.cep-mask').mask('00000-000', {
        reverse: false,
        placeholder: '00000-000'
    });

    // Máscara de moeda
    $('.money-mask').mask('#.##0,00', {
        reverse: true,
        placeholder: '0,00'
    });

    // Máscara de porcentagem
    $('.percent-mask').mask('##0,00%', {
        reverse: true,
        placeholder: '0,00%'
    });
});
