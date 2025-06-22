/**
 * Busca de CEP via ViaCEP
 * Sistema Admin
 */

$(document).ready(function() {
    // Função para buscar CEP
    function buscarCEP(cep) {
        // Remove caracteres não numéricos
        cep = cep.replace(/\D/g, '');

        // Verifica se o CEP tem 8 dígitos
        if (cep.length !== 8) {
            return;
        }

        // Mostra loading nos campos
        $('#endereco, #bairro, #cidade, #estado').prop('disabled', true).val('Carregando...');

        // Faz a requisição para a API do ViaCEP
        $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
            if (!data.erro) {
                // Preenche os campos
                $('#endereco').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.localidade);
                $('#estado').val(data.uf);
            } else {
                alert('CEP não encontrado!');
            }
        }).fail(function() {
            alert('Erro ao buscar CEP. Tente novamente.');
        }).always(function() {
            // Remove o loading
            $('#endereco, #bairro, #cidade, #estado').prop('disabled', false);

            // Se não encontrou, limpa os campos
            if (!$('#endereco').val() || $('#endereco').val() === 'Carregando...') {
                $('#endereco, #bairro, #cidade').val('');
            }
        });
    }

    // Evento de blur no campo CEP
    $(document).on('blur', '#cep', function() {
        const cep = $(this).val();
        if (cep) {
            buscarCEP(cep);
        }
    });
});
