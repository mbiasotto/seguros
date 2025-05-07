@extends('vendor.layouts.app') {{-- Assuming a vendor layout exists --}}

@section('title', 'Novo Estabelecimento')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Novo Estabelecimento</h1>
        @include('admin.components.back-button', ['route' => route('vendor.establishments.index')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('vendor.establishments.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
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

                        {{-- Form fields remain the same --}}
                         <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="category_id" class="form-label">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" id="category_id" name="category_id" required>
                                        <option value="">Selecione uma categoria</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-sm">Selecione a categoria do estabelecimento</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4 pt-md-4 mt-md-2">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }} style="width: 3em; height: 1.5em;">
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
                                    <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ old('nome') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cnpj" class="form-label">CNPJ</label>
                                    <input type="text" class="form-control form-control-lg cnpj-mask" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00">
                                    <div class="form-text text-sm">Opcional</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg phone-mask" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" required>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Endereço</h2>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg cep-mask" id="cep" name="cep" value="{{ old('cep') }}" placeholder="00000-000" required>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label for="endereco" class="form-label">Endereço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="endereco" name="endereco" value="{{ old('endereco') }}" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control form-control-lg" id="numero" name="numero" value="{{ old('numero') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" value="{{ old('cidade') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
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

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Materiais</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                    <div class="form-text text-sm">Opcional. Recomendado: Fundo transparente, formato PNG ou SVG.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Imagem</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <div class="form-text text-sm">Opcional. Imagem principal para o estabelecimento.</div>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">QR Codes</h2>
                        <x-qr-code-manager :qrCodes="$qrCodes" />

                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <a href="{{ route('vendor.establishments.index') }}" class="btn btn-light">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Incluindo o modal de remoção --}}
<x-qr-code-remove-modal />

@push('scripts')
{{-- Utility Scripts --}}
<script src="{{ asset('assets/js/utils/input-masks.js') }}"></script>
<script src="{{ asset('assets/js/utils/cep-lookup.js') }}"></script>
<script src="{{ asset('assets/js/components/qr-code-manager.js') }}"></script>
@endpush

@endsection
