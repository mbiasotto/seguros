@extends('vendor.layouts.app')

@section('title', 'Novo Estabelecimento')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold">Novo Estabelecimento</h2>
                <a href="{{ route('vendor.establishments.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                <form action="{{ route('vendor.establishments.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Não exibimos o campo de vendedor responsável na área do vendor -->
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 pt-md-4 mt-md-2">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }} style="width: 3em; height: 1.5em;">
                                    <label class="form-check-label fs-5 ms-2" for="ativo">Estabelecimento Ativo</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-4 fw-bold">Informações Principais</h5>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="nome" class="form-label fw-semibold">Nome do Estabelecimento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ old('nome') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="telefone" class="form-label fw-semibold">Telefone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="email@exemplo.com" required>
                                <div class="invalid-feedback">
                                    Por favor, informe um e-mail válido para o estabelecimento.
                                </div>
                                <div class="form-text">Um e-mail de boas-vindas será enviado para este endereço.</div>
                            </div>
                        </div>

                    </div>

                    <h5 class="border-bottom pb-2 mb-4 fw-bold">Endereço</h5>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label for="cep" class="form-label fw-semibold">CEP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="cep" name="cep" value="{{ old('cep') }}" placeholder="00000-000" required>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="mb-4">
                                <label for="endereco" class="form-label fw-semibold">Endereço <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="endereco" name="endereco" value="{{ old('endereco') }}" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb-4">
                                <label for="numero" class="form-label fw-semibold">Número</label>
                                <input type="text" class="form-control form-control-lg" id="numero" name="numero" value="{{ old('numero') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="cidade" class="form-label fw-semibold">Cidade <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" value="{{ old('cidade') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('estado') is-invalid @enderror"
                                       id="estado" name="estado" required>
                                    <option value="">Selecione o estado</option>
                                    @foreach(\App\Models\Estado::orderBy('nome')->get() as $estado)
                                        <option value="{{ $estado->sigla }}" {{ old('estado') == $estado->sigla ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-4 fw-bold">QR Codes</h5>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Selecione os QR Codes para este estabelecimento</label>
                                <p class="text-muted">Você pode vincular um ou mais QR Codes ao estabelecimento. Apenas QR Codes disponíveis ou já vinculados aos seus estabelecimentos são exibidos.</p>

                                <!-- Seleção de QR Codes disponíveis -->
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <select class="form-select" id="qrcode-select">
                                            <option value="">Selecione um QR Code disponível</option>
                                            @foreach($qrCodes as $qrCode)
                                                @if($qrCode->isAvailableFor())
                                                    <option value="{{ $qrCode->id }}" data-title="{{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}" data-description="{{ $qrCode->description ?: $qrCode->link }}">
                                                        #{{ $qrCode->id }} - {{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary w-100" id="add-qrcode-btn">
                                            <i class="fas fa-plus me-2"></i> Adicionar QR Code
                                        </button>
                                    </div>
                                </div>

                                <!-- Lista de QR Codes vinculados -->
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">QR Codes vinculados a este estabelecimento</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush" id="linked-qrcodes-list">
                                            <li class="list-group-item text-center py-4" id="no-qrcodes-message">
                                                <div class="text-muted">
                                                    <i class="fas fa-info-circle me-2"></i> Nenhum QR Code vinculado a este estabelecimento.
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Confirmação para Remover QR Code -->
                    <div class="modal fade" id="removeQrCodeModal" tabindex="-1" aria-labelledby="removeQrCodeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
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

                    @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const qrcodeSelect = document.getElementById('qrcode-select');
                            const addQrcodeBtn = document.getElementById('add-qrcode-btn');
                            const linkedQrcodesList = document.getElementById('linked-qrcodes-list');
                            const noQrcodesMessage = document.getElementById('no-qrcodes-message');
                            const removeQrCodeModalEl = document.getElementById('removeQrCodeModal');
                            let removeQrCodeModal;

                            // Verifica se o Bootstrap está disponível
                            if (typeof bootstrap !== 'undefined') {
                                removeQrCodeModal = new bootstrap.Modal(removeQrCodeModalEl);
                            }

                            const confirmRemoveQrCodeBtn = document.getElementById('confirm-remove-qrcode');
                            const qrcodeTitleToRemove = document.getElementById('qrcode-title-to-remove');

                            // Variáveis para armazenar temporariamente os dados do QR Code a ser removido
                            let qrcodeToRemove = {
                                id: null,
                                title: null,
                                description: null
                            };

                            // Função para adicionar um QR Code à lista de vinculados
                            function addQrCode() {
                                // Verifica se um QR Code foi selecionado
                                if (!qrcodeSelect.value) {
                                    return;
                                }

                                // Remove a mensagem de "nenhum QR Code vinculado" se existir
                                if (noQrcodesMessage) {
                                    noQrcodesMessage.remove();
                                }

                                const qrcodeId = qrcodeSelect.value;
                                const qrcodeOption = qrcodeSelect.options[qrcodeSelect.selectedIndex];
                                const qrcodeTitle = qrcodeOption.getAttribute('data-title');
                                const qrcodeDescription = qrcodeOption.getAttribute('data-description');

                                // Cria o elemento de lista para o QR Code
                                const listItem = document.createElement('li');
                                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                                listItem.id = `linked-qrcode-${qrcodeId}`;

                                // Conteúdo do item
                                listItem.innerHTML = `
                                    <div>
                                        <input type="hidden" name="qr_codes[]" value="${qrcodeId}">
                                        <strong>#${qrcodeId} - ${qrcodeTitle}</strong>
                                        <small class="text-muted d-block">${qrcodeDescription}</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-qrcode" data-id="${qrcodeId}" data-title="${qrcodeTitle}" data-description="${qrcodeDescription}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                `;

                                // Adiciona o item à lista
                                linkedQrcodesList.appendChild(listItem);

                                // Remove a opção do select
                                qrcodeSelect.removeChild(qrcodeOption);

                                // Limpa a seleção
                                qrcodeSelect.value = '';

                                // Adiciona evento para mostrar o modal de confirmação
                                const removeButton = listItem.querySelector('.remove-qrcode');
                                removeButton.addEventListener('click', function() {
                                    // Armazena os dados do QR Code a ser removido
                                    qrcodeToRemove.id = this.getAttribute('data-id');
                                    qrcodeToRemove.title = this.getAttribute('data-title');
                                    qrcodeToRemove.description = this.getAttribute('data-description');

                                    // Atualiza o texto do modal com o título do QR Code
                                    qrcodeTitleToRemove.textContent = `#${qrcodeToRemove.id} - ${qrcodeToRemove.title}`;

                                    // Exibe o modal de confirmação
                                    if (removeQrCodeModal) {
                                        removeQrCodeModal.show();
                                    } else {
                                        // Fallback se o bootstrap não estiver disponível
                                        if (confirm(`Deseja remover o QR Code #${qrcodeToRemove.id} - ${qrcodeToRemove.title}?`)) {
                                            removeQrCode(qrcodeToRemove.id, qrcodeToRemove.title, qrcodeToRemove.description);
                                        }
                                    }
                                });
                            }

                            // Função para remover um QR Code da lista de vinculados
                            function removeQrCode(qrcodeId, qrcodeTitle, qrcodeDescription) {
                                // Remove o item da lista
                                const listItem = document.getElementById(`linked-qrcode-${qrcodeId}`);
                                if (listItem) {
                                    listItem.remove();
                                }

                                // Adiciona a opção de volta ao select
                                const option = document.createElement('option');
                                option.value = qrcodeId;
                                option.setAttribute('data-title', qrcodeTitle);
                                option.setAttribute('data-description', qrcodeDescription);
                                option.textContent = `#${qrcodeId} - ${qrcodeTitle}`;
                                qrcodeSelect.appendChild(option);

                                // Se não houver mais QR Codes vinculados, mostra a mensagem
                                if (linkedQrcodesList.children.length === 0) {
                                    const noQrcodesItem = document.createElement('li');
                                    noQrcodesItem.className = 'list-group-item text-center py-4';
                                    noQrcodesItem.id = 'no-qrcodes-message';
                                    noQrcodesItem.innerHTML = `
                                        <div class="text-muted">
                                            <i class="fas fa-info-circle me-2"></i> Nenhum QR Code vinculado a este estabelecimento.
                                        </div>
                                    `;
                                    linkedQrcodesList.appendChild(noQrcodesItem);
                                }
                            }

                            // Adiciona evento ao botão de adicionar QR Code
                            addQrcodeBtn.addEventListener('click', addQrCode);

                            // Adiciona evento ao botão de confirmar remoção no modal
                            if (confirmRemoveQrCodeBtn) {
                                confirmRemoveQrCodeBtn.addEventListener('click', function() {
                                    // Remove o QR Code
                                    removeQrCode(qrcodeToRemove.id, qrcodeToRemove.title, qrcodeToRemove.description);

                                    // Fecha o modal
                                    if (removeQrCodeModal) {
                                        removeQrCodeModal.hide();
                                    }

                                    // Limpa os dados temporários
                                    qrcodeToRemove = {
                                        id: null,
                                        title: null,
                                        description: null
                                    };
                                });
                            }
                        });
                    </script>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
                    <script src="{{ asset('js/form-utils.js') }}"></script>
                    @endpush

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('vendor.establishments.index') }}" class="btn btn-outline-secondary btn-lg me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save me-2"></i> Cadastrar Estabelecimento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
