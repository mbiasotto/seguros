<!-- Modal de Confirmação para Remover QR Code -->
<div class="modal fade" id="removeQrCodeModal" tabindex="-1" aria-labelledby="removeQrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="removeQrCodeModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmar Remoção
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Você está prestes a desvincular o QR Code <strong id="qrcode-title-to-remove"></strong> deste estabelecimento.</p>
                <p class="mb-0">Tem certeza que deseja continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirm-remove-qrcode">
                    <i class="fas fa-unlink me-2"></i> Sim, Desvincular
                </button>
            </div>
        </div>
    </div>
</div>
