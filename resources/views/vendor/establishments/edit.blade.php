@extends('vendor.layouts.app')

@section('title', 'Editar Estabelecimento')

@push('styles')
{{-- Remove specific CSS, rely on admin/admin.css --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/css/data-list.css') }}"> --}}
@endpush

@section('content')
<div class="container-fluid px-0"> {{-- Keep container --}}
    {{-- Use admin page header structure --}}
    <div class="page-header">
        <h1 class="page-title">Editar Estabelecimento</h1>
        {{-- Add admin back button component --}}
        @include('admin.components.back-button', ['route' => route('vendor.establishments.index')])
    </div>

    <div class="row">
        <div class="col-12">
            {{-- Use admin card structure --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('vendor.establishments.update', $establishment) }}" method="POST" class="needs-validation" novalidate>
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
                                {{-- Vendor doesn't select responsible vendor --}}
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

                        {{-- Use admin section title style --}}
                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações Principais</h2>

                        {{-- Use admin form row structure --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                {{-- Use admin form group style (mb-3) --}}
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
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg phone-mask" id="telefone" name="telefone" value="{{ old('telefone', $establishment->telefone) }}" placeholder="(00) 00000-0000" required>
                                    <div class="invalid-feedback">
                                        Por favor, informe o telefone do estabelecimento.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email', $establishment->email) }}" placeholder="email@exemplo.com" required>
                                    <div class="invalid-feedback">
                                        Por favor, informe um e-mail válido para o estabelecimento.
                                    </div>
                                    <div class="form-text text-sm">Este e-mail será usado para enviar o aceite e comunicações importantes.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Use admin section title style --}}
                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Endereço</h2>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg cep-mask" id="cep" name="cep" value="{{ old('cep', $establishment->cep) }}" placeholder="00000-000" required>
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

                        {{-- Use admin section title style --}}
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
                                    <label for="image" class="form-label">Imagem</label>
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

                        {{-- Use admin section title style --}}
                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">QR Codes</h2>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Selecione os QR Codes para este estabelecimento</label>
                                    <p class="text-muted text-sm">Você pode vincular um ou mais QR Codes ao estabelecimento. Apenas QR Codes disponíveis ou já vinculados aos seus estabelecimentos são exibidos.</p>

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
                                    {{-- Use admin card structure for linked list --}}
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
                                                        <div class="text-muted text-sm">
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

                         {{-- Use admin action button structure --}}
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('vendor.establishments.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
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

{{-- Include the shared modal component --}}
@include('vendor.components.qr-code-remove-modal')

@push('scripts')
{{-- Include admin scripts for CEP and QR management --}}
<script>
    $(document).ready(function(){
        // Preenchimento automático de CEP (Same as admin)
        $('#cep').blur(function(){
            const cep = $(this).val().replace(/\D/g, '');
            if(cep.length === 8){
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data){
                    if(!data.erro){
                        $('#endereco').val(data.logradouro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    }
                });
            }
        });
    });
</script>
{{-- Use admin QR code manager script (already included in previous edit, just ensuring it stays) --}}
<script src="{{ asset('assets/admin/js/pages/establishments/qr-code-manager.js') }}"></script>
{{-- Removed the embedded QR code management script block --}}
@endpush
@endsection
