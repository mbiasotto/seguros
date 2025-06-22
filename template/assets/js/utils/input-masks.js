$(document).ready(function() {
    if (typeof $.fn.mask === 'function') {
        $('.cnpj-mask').mask('00.000.000/0000-00', { reverse: true });
        $('.phone-mask').mask('(00) 00000-0000');
        $('.cep-mask').mask('00000-000');
        // Add other masks here if needed, e.g.:
        $('.date-mask').mask('00/00/0000');
        $('.cpf-mask').mask('000.000.000-00', { reverse: true });
    } else {
        console.warn('jQuery Mask Plugin not loaded.');
    }
});
