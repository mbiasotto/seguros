$(document).ready(function() {
    // Carrega os dados do QR Code do script JSON
    const qrCodeData = JSON.parse($('#page-qr-code-data').text());
    let selectedQrCodeToRemove = null;

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
            <li class="list-group-item d-flex justify-content-between align-items-center" id="linked-qrcode-${qrCode.id}">
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
            </li>
        `;
    }

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
            description: selectedOption.data('description')
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
    updateNoQrCodesMessage();
});
