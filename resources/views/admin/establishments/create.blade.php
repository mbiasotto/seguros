@extends('admin.layouts.app')

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
                <a href="{{ route('admin.establishments.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.establishments.store') }}" method="POST" class="needs-validation" novalidate>
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
                                <div class="mb-4">
                                    <label for="vendor_id" class="form-label fw-semibold">Vendedor Responsável <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" id="vendor_id" name="vendor_id" required>
                                        <option value="">Selecione um vendedor</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Selecione o vendedor responsável por este estabelecimento</div>
                                </div>
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

                        <h5 class="border-bottom pb-2 mb-4">Informações Principais</h5>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label fw-semibold">Nome do Estabelecimento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ old('nome') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label fw-semibold">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4">Endereço</h5>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endereco" class="form-label fw-semibold">Endereço Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="endereco" name="endereco" value="{{ old('endereco') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label fw-semibold">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" value="{{ old('cidade') }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="estado" name="estado" maxlength="2" value="{{ old('estado') }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cep" class="form-label fw-semibold">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="cep" name="cep" value="{{ old('cep') }}" placeholder="00000-000" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4">QR Codes</h5>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Selecione os QR Codes para este estabelecimento</label>
                                    <div class="qr-code-selection mt-3">
                                        <div class="row g-3">
                                            @if($qrCodes->count() > 0)
                                                @foreach($qrCodes as $qrCode)
                                                    <div class="col-md-4 col-lg-3">
                                                        <div class="card h-100 qr-code-card {{ $qrCode->isAvailableFor() ? '' : 'border-warning' }}">
                                                            <div class="card-body">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="qr_codes[]"
                                                                        value="{{ $qrCode->id }}" id="qr_code_{{ $qrCode->id }}"
                                                                        {{ in_array($qrCode->id, old('qr_codes', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label w-100" for="qr_code_{{ $qrCode->id }}">
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <span class="badge {{ $qrCode->isAvailableFor() ? 'bg-success' : 'bg-warning' }} me-2">
                                                                                {{ $qrCode->isAvailableFor() ? 'Disponível' : 'Em uso' }}
                                                                            </span>
                                                                            <h6 class="mb-0 text-truncate">{{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}</h6>
                                                                        </div>
                                                                        <div class="qr-code-preview text-center my-2">
                                                                            <img src="{{ route('admin.qr-codes.download', $qrCode) }}"
                                                                                alt="QR Code #{{ $qrCode->id }}" class="img-fluid" style="max-width: 100px;">
                                                                        </div>
                                                                        <small class="text-muted d-block text-truncate">{{ $qrCode->description ?: $qrCode->link }}</small>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12">
                                                    <div class="alert alert-info mb-0">
                                                        <i class="fas fa-info-circle me-2"></i> Não há QR Codes disponíveis.
                                                        <a href="{{ route('admin.qr-codes.create') }}" class="alert-link">Criar um novo QR Code</a>.
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.establishments.index') }}" class="btn btn-outline-secondary btn-lg me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i> Salvar Estabelecimento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
