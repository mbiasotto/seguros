$(document).ready(function() {
    // Carrega os dados do QR Code do script JSON
    const qrCodeData = JSON.parse($('#page-qr-code-data').text());
    let selectedQrCodeToRemove = null;

    // Log para debug
    console.log('Dados de QR Code carregados:', qrCodeData);

    // Função para atualizar a mensagem de "Nenhum QR Code"
    function updateNoQrCodesMessage() {
        const hasQrCodes = $('#linked-qrcodes-list li:not(#no-qrcodes-message)').length > 0;
        if (hasQrCodes) {
            $('#no-qrcodes-message').hide();
        } else {
            $('#no-qrcodes-message').show();
        }
    }

    // Função para criar o item da lista de QR Code
    function createQrCodeListItem(qrCode) {
        return `
            <li class="list-group-item" id="linked-qrcode-${qrCode.id}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <input type="hidden" name="qr_codes[]" value="${qrCode.id}">
                        <strong class="font-medium">QR Code #${qrCode.id}</strong>
                        <small class="text-muted text-sm d-block"></small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-qrcode"
                            data-id="${qrCode.id}"
                            data-title="QR Code #${qrCode.id}"
                            data-description="${qrCode.description}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" name="qr_notes[${qrCode.id}]" id="qr-notes-${qrCode.id}" style="height: 80px" placeholder="Anotações sobre este QR Code">${qrCode.notes || ''}</textarea>
                    <label for="qr-notes-${qrCode.id}">Anotações</label>
                </div>
            </li>
        `;
    }

    // Inicialização: carregar QR Codes do estabelecimento se necessário
    function initializeQrCodeList() {
        // Verificar se precisamos pré-preencher a lista a partir do lado do cliente
        // (isso pode acontecer se a lista não foi preenchida no servidor)
        if (qrCodeData.establishmentQrCodes && qrCodeData.establishmentQrCodes.length > 0) {
            // Se não houver elementos na lista mas temos dados, precisamos adicionar via cliente
            if ($('#linked-qrcodes-list li:not(#no-qrcodes-message)').length === 0) {
                console.log('Preenchendo QR Codes do estabelecimento no cliente:', qrCodeData.establishmentQrCodes);

                // Limpar a lista atual
                $('#linked-qrcodes-list').empty();

                // Adicionar os QR Codes do estabelecimento
                qrCodeData.establishmentQrCodes.forEach(qrCode => {
                    const listItem = createQrCodeListItem(qrCode);
                    $('#linked-qrcodes-list').append(listItem);
                });
            }
        }

        // Atualizar a mensagem de "Nenhum QR Code"
        updateNoQrCodesMessage();

        // Remover do select os QR Codes que já estão vinculados
        updateQrCodeSelect();
    }

    // Atualizar o select de QR Codes disponíveis
    function updateQrCodeSelect() {
        // Obter IDs dos QR Codes já vinculados
        const linkedQrCodeIds = [];
        $('#linked-qrcodes-list input[name="qr_codes[]"]').each(function() {
            linkedQrCodeIds.push($(this).val());
        });

        // Redefinir o select
        const select = $('#qrcode-select');
        select.empty();
        select.append('<option value="">Selecione um QR Code disponível</option>');

        // Adicionar apenas os QR Codes não vinculados
        qrCodeData.allQrCodes.forEach(qrCode => {
            if (!linkedQrCodeIds.includes(qrCode.id.toString())) {
                const option = new Option(`QR Code #${qrCode.id}`, qrCode.id);
                $(option).data({
                    title: `QR Code #${qrCode.id}`,
                    description: qrCode.description
                });
                select.append(option);
            }
        });
    }

    // Filtrar QR Codes
    $('#qrcode-search').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();

        // Obter IDs dos QR Codes já vinculados
        const linkedQrCodeIds = [];
        $('#linked-qrcodes-list input[name="qr_codes[]"]').each(function() {
            linkedQrCodeIds.push($(this).val());
        });

        // Redefinir o select
        const select = $('#qrcode-select');
        select.empty();
        select.append('<option value="">Selecione um QR Code disponível</option>');

        // Filtrar e adicionar opções baseadas na busca
        qrCodeData.allQrCodes.forEach(qrCode => {
            // Verifica se o QR Code já está vinculado ao estabelecimento
            const isLinked = linkedQrCodeIds.includes(qrCode.id.toString());

            // Se não estiver vinculado e corresponder ao termo de busca
            if (!isLinked && `QR Code #${qrCode.id}`.toLowerCase().includes(searchTerm)) {
                const option = new Option(`QR Code #${qrCode.id}`, qrCode.id);
                $(option).data({
                    title: `QR Code #${qrCode.id}`,
                    description: qrCode.description
                });
                select.append(option);
            }
        });
    });

    // Adicionar QR Code
    $('#add-qrcode-btn').on('click', function() {
        const select = $('#qrcode-select');
        const selectedOption = select.find('option:selected');
        const qrCodeId = select.val();

        if (!qrCodeId) {
            return;
        }

        const qrCode = {
            id: qrCodeId,
            title: `QR Code #${qrCodeId}`,
            description: selectedOption.data('description'),
            notes: ''
        };

        // Adiciona o QR Code à lista
        const listItem = createQrCodeListItem(qrCode);
        $('#linked-qrcodes-list').append(listItem);

        // Remove a opção do select
        selectedOption.remove();
        select.val('');

        // Atualiza a mensagem de "Nenhum QR Code"
        updateNoQrCodesMessage();
    });

    // Remover QR Code (abre modal)
    $(document).on('click', '.remove-qrcode', function() {
        selectedQrCodeToRemove = {
            id: $(this).data('id'),
            title: `QR Code #${$(this).data('id')}`,
            description: $(this).data('description')
        };

        $('#qrcode-title-to-remove').text(selectedQrCodeToRemove.title);
        $('#removeQrCodeModal').modal('show');
    });

    // Confirmar remoção do QR Code
    $('#confirmRemoveQrCodeBtn').on('click', function() {
        if (!selectedQrCodeToRemove) return;

        // Remove o item da lista
        $(`#linked-qrcode-${selectedQrCodeToRemove.id}`).remove();

        // Adiciona o QR Code de volta ao select
        const option = new Option(
            `QR Code #${selectedQrCodeToRemove.id}`,
            selectedQrCodeToRemove.id
        );
        $(option).data({
            title: selectedQrCodeToRemove.title,
            description: selectedQrCodeToRemove.description
        });
        $('#qrcode-select').append(option);

        // Fecha o modal
        $('#removeQrCodeModal').modal('hide');

        // Atualiza a mensagem de "Nenhum QR Code"
        updateNoQrCodesMessage();

        // Limpa o QR Code selecionado
        selectedQrCodeToRemove = null;
    });

    // Inicialização
    initializeQrCodeList();
});
