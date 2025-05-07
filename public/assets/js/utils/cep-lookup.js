$(document).ready(function() {
    function bindCepLookup(cepFieldSelector, addressFieldSelector, cityFieldSelector, stateFieldSelector, neighborhoodFieldSelector = null) {
        $(document).on('blur', cepFieldSelector, function() {
            const cep = $(this).val().replace(/\D/g, '');

            if (cep.length === 8) {
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                    if (!data.erro) {
                        $(addressFieldSelector).val(data.logradouro);
                        $(cityFieldSelector).val(data.localidade);
                        $(stateFieldSelector).val(data.uf).trigger('change'); // Trigger change for select2 or other plugins

                        if (neighborhoodFieldSelector && data.bairro) {
                            $(neighborhoodFieldSelector).val(data.bairro);
                        }
                    } else {
                        console.warn("CEP não encontrado:", cep);
                    }
                }).fail(function(jqxhr, textStatus, error) {
                    console.error("Erro ao buscar CEP:", textStatus, error);
                });
            }
        });
    }

    // Initialize for any forms that might use these specific IDs
    // This can be made more generic if needed, e.g., by using data-attributes to specify target fields
    bindCepLookup('#cep', '#endereco', '#cidade', '#estado', '#bairro'); // Assuming #bairro might exist
});
