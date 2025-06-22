/**
 * Documento Tipo Toggle - Controla a exibição de campos CPF/CNPJ conforme o tipo de documento selecionado
 *
 * Este script manipula a visibilidade dos campos CPF e CNPJ com base no tipo de documento selecionado
 * (pessoa física ou jurídica), e também atualiza os atributos required dos campos conforme necessário.
 *
 * @requires jQuery
 */
$(document).ready(function() {
    // Elementos do formulário
    const $tipoPjRadio = $('#tipo_pj');
    const $tipoPfRadio = $('#tipo_pf');
    const $documentoPj = $('.documento-pj');
    const $documentoPf = $('.documento-pf');
    const $cnpjInput = $('#cnpj');
    const $cpfInput = $('#cpf');

    /**
     * Alterna a visibilidade e requerimento dos campos de documento
     * com base no tipo de documento selecionado
     */
    function toggleDocumentoFields() {
        if ($tipoPjRadio.is(':checked')) {
            $documentoPj.show();
            $documentoPf.hide();
            $cnpjInput.prop('required', true);
            $cpfInput.prop('required', false);
        } else {
            $documentoPj.hide();
            $documentoPf.show();
            $cnpjInput.prop('required', false);
            $cpfInput.prop('required', true);
        }
    }

    // Adiciona listeners para os radios
    $tipoPjRadio.on('change', toggleDocumentoFields);
    $tipoPfRadio.on('change', toggleDocumentoFields);

    // Inicializa o estado dos campos ao carregar a página
    toggleDocumentoFields();
});
