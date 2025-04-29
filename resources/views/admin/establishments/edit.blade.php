@extends('admin.layouts.app')

@section('title', 'Editar Estabelecimento')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
@push('styles')
<style>
    /* Estilos para a tabela de QR codes */
    .table-sm td {
        padding: 0.4rem 0.5rem;
    }
    .qr-code-item:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .pagination-container .page-link {
        padding: 0.25rem 0.5rem;
        font-size: var(--font-size-sm);
    }
    .filter-container {
        background-color: #f8f9fa;
        border-radius: var(--border-radius);
        padding: 0.75rem;
        margin-bottom: 1rem;
    }
</style>
@endpush
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Editar Estabelecimento</h1>
                <a href="{{ route('admin.establishments.index') }}" class="btn btn-outline-secondary font-medium">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.establishments.update', $establishment) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

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
                                <div class="mb-4">
                                    <label for="vendor_id" class="form-label">Vendedor Responsável <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" id="vendor_id" name="vendor_id" required>
                                        <option value="">Selecione um vendedor</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ old('vendor_id', $establishment->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-sm">Selecione o vendedor responsável por este estabelecimento</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 pt-md-4 mt-md-2">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" {{ old('ativo', $establishment->ativo) ? 'checked' : '' }} style="width: 3em; height: 1.5em;">
                                        <label class="form-check-label fs-5 ms-2" for="ativo">Estabelecimento Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações Principais</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome do Estabelecimento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ old('nome', $establishment->nome) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cnpj" class="form-label">CNPJ</label>
                                    <input type="text" class="form-control form-control-lg cnpj-mask" id="cnpj" name="cnpj" value="{{ old('cnpj', $establishment->cnpj) }}" placeholder="00.000.000/0000-00">
                                    <div class="form-text text-sm">Opcional</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email', $establishment->email) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" value="{{ old('telefone', $establishment->telefone) }}" placeholder="(00) 00000-0000" required>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Endereço</h2>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="cep" name="cep" value="{{ old('cep', $establishment->cep) }}" placeholder="00000-000" required>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label for="endereco" class="form-label">Endereço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="endereco" name="endereco" value="{{ old('endereco', $establishment->endereco) }}" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control form-control-lg" id="numero" name="numero" value="{{ old('numero', $establishment->numero) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" value="{{ old('cidade', $establishment->cidade) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('estado') is-invalid @enderror"
                                           id="estado" name="estado" required>
                                        <option value="">Selecione o estado</option>
                                        @foreach(\App\Models\Estado::orderBy('nome')->get() as $estado)
                                            <option value="{{ $estado->sigla }}" {{ old('estado', $establishment->estado) == $estado->sigla ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                        @endforeach
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Materiais</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                    <div class="form-text text-sm mb-2">Opcional. Envie um novo arquivo para substituir o atual.</div>
                                    @if($establishment->logo)
                                        <a href="{{ Storage::url($establishment->logo) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye me-1"></i> Ver Logo Atual
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Imagem de Capa</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <div class="form-text text-sm mb-2">Opcional. Envie um novo arquivo para substituir o atual.</div>
                                     @if($establishment->image)
                                        <a href="{{ Storage::url($establishment->image) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye me-1"></i> Ver Imagem Atual
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">QR Codes</h2>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Selecione os QR Codes para este estabelecimento</label>

                                    <!-- Seleção de QR Codes disponíveis -->
                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                            <select class="form-select" id="qrcode-select">
                                                <option value="">Selecione um QR Code disponível</option>
                                                @foreach($qrCodes as $qrCode)
                                                    @if($qrCode->isAvailableFor($establishment) && !$establishment->qrCodes->contains($qrCode->id))
                                                        <option value="{{ $qrCode->id }}" data-title="{{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}" data-description="{{ $qrCode->description ?: $qrCode->link }}">
                                                            #{{ $qrCode->id }} - {{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary w-100 font-medium" id="add-qrcode-btn">
                                                <i class="fas fa-plus me-2"></i> Adicionar QR Code
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Lista de QR Codes vinculados -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="font-medium mb-0">QR Codes vinculados a este estabelecimento</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <ul class="list-group list-group-flush" id="linked-qrcodes-list">
                                                @if($establishment->qrCodes->count() > 0)
                                                    @foreach($establishment->qrCodes as $qrCode)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center" id="linked-qrcode-{{ $qrCode->id }}">
                                                            <div>
                                                                <input type="hidden" name="qr_codes[]" value="{{ $qrCode->id }}">
                                                                <strong class="font-medium">#{{ $qrCode->id }} - {{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}</strong>
                                                                <small class="text-muted text-sm d-block">{{ $qrCode->description ?: $qrCode->link }}</small>
                                                            </div>
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-qrcode" data-id="{{ $qrCode->id }}" data-title="{{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}" data-description="{{ $qrCode->description ?: $qrCode->link }}">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="list-group-item text-center py-4" id="no-qrcodes-message">
                                                        <div class="text-muted">
                                                            <i class="fas fa-info-circle me-2"></i> Nenhum QR Code vinculado a este estabelecimento.
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.establishments.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="fas fa-save me-2"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
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

        // Função para adicionar um QR Code à lista de vinculados
        function addQrCode() {
            // Verifica se um QR Code foi selecionado
            if (!qrcodeSelect.value) {
                return;
            }

            // Remove a mensagem de nenhum QR Code se existir
            if (noQrcodesMessage) {
                noQrcodesMessage.remove();
            }

            // Obtém os dados do QR Code selecionado
            const qrCodeId = qrcodeSelect.value;
            const option = qrcodeSelect.options[qrcodeSelect.selectedIndex];
            const qrCodeTitle = option.dataset.title;
            const qrCodeDescription = option.dataset.description;

            // Cria o item da lista
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.id = `linked-qrcode-${qrCodeId}`;
            li.innerHTML = `
                <div>
                    <input type="hidden" name="qr_codes[]" value="${qrCodeId}">
                    <strong class="font-medium">${qrCodeTitle}</strong>
                    <small class="text-muted text-sm d-block">${qrCodeDescription}</small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-qrcode" data-id="${qrCodeId}" data-title="${qrCodeTitle}" data-description="${qrCodeDescription}">
                    <i class="fas fa-times"></i>
                </button>
            `;

            // Adiciona o item à lista
            linkedQrcodesList.appendChild(li);

            // Adiciona o evento de remoção ao botão
            li.querySelector('.remove-qrcode').addEventListener('click', function() {
                removeQrCode(this.dataset.id, this.dataset.title, this.dataset.description);
            });

            // Remove a opção do select
            qrcodeSelect.remove(qrcodeSelect.selectedIndex);

            // Se não houver mais opções, desabilita o select e o botão
            if (qrcodeSelect.options.length <= 1) {
                qrcodeSelect.disabled = true;
                addQrcodeBtn.disabled = true;
            }
        }

        // Função para remover um QR Code da lista de vinculados
        function removeQrCode(id, title, description) {
            // Remove o item da lista
            document.getElementById(`linked-qrcode-${id}`).remove();

            // Adiciona a opção de volta ao select
            const option = document.createElement('option');
            option.value = id;
            option.dataset.title = title;
            option.dataset.description = description;
            option.textContent = `#${id} - ${title}`;
            qrcodeSelect.appendChild(option);

            // Habilita o select e o botão
            qrcodeSelect.disabled = false;
            addQrcodeBtn.disabled = false;

            // Se não houver mais itens na lista, adiciona a mensagem de nenhum QR Code
            if (!linkedQrcodesList.querySelector('li:not(#no-qrcodes-message)')) {
                const li = document.createElement('li');
                li.className = 'list-group-item text-center py-4';
                li.id = 'no-qrcodes-message';
                li.innerHTML = `
                    <div class="text-muted">
                        <i class="fas fa-info-circle me-2"></i> Nenhum QR Code vinculado a este estabelecimento.
                    </div>
                `;
                linkedQrcodesList.appendChild(li);
            }
        }

        // Adiciona o evento de clique ao botão de adicionar
        addQrcodeBtn.addEventListener('click', addQrCode);

        // Adiciona o evento de clique aos botões de remover
        document.querySelectorAll('.remove-qrcode').forEach(button => {
            button.addEventListener('click', function() {
                removeQrCode(this.dataset.id, this.dataset.title, this.dataset.description);
            });
        });
    });
</script>
@endpush
@endsection
