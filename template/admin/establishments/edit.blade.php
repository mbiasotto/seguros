@extends('admin.layouts.app')

@section('title', 'Editar Estabelecimento')


@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Editar Estabelecimento</h1>
        @include('admin.components.back-button', ['route' => route('admin.establishments.index')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.establishments.update', $establishment) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
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

                        {{-- Form fields remain the same --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="vendor_id" class="form-label">Vendedor Responsável <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" id="vendor_id" name="vendor_id" required>
                                        <option value="">Selecione um vendedor</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" {{ (old('vendor_id', $establishment->vendor_id) == $vendor->id) ? 'selected' : '' }}>
                                                {{ $vendor->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-sm">Selecione o vendedor responsável por este estabelecimento</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="category_id" class="form-label">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" id="category_id" name="category_id" required>
                                        <option value="">Selecione uma categoria</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('category_id', $establishment->category_id) == $category->id) ? 'selected' : '' }}>
                                                {{ $category->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-sm">Selecione a categoria do estabelecimento</div>
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
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="tipo_documento" class="form-label">Tipo de Pessoa <span class="text-danger">*</span></label>
                                    <div class="d-flex mt-2">
                                        <div class="form-check me-4">
                                            <input class="form-check-input" type="radio" name="tipo_documento" id="tipo_pj" value="pj" {{ old('tipo_documento', $establishment->tipo_documento ?? 'pj') == 'pj' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tipo_pj">
                                                Pessoa Jurídica
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_documento" id="tipo_pf" value="pf" {{ old('tipo_documento', $establishment->tipo_documento ?? 'pj') == 'pf' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tipo_pf">
                                                Pessoa Física
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ old('nome', $establishment->nome) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 documento-pj" {{ old('tipo_documento', $establishment->tipo_documento ?? 'pj') == 'pf' ? 'style=display:none' : '' }}>
                                <div class="mb-3">
                                    <label for="cnpj" class="form-label">CNPJ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg cnpj-mask" id="cnpj" name="cnpj" value="{{ old('cnpj', $establishment->cnpj) }}" placeholder="00.000.000/0000-00" {{ old('tipo_documento', $establishment->tipo_documento ?? 'pj') == 'pj' ? 'required' : '' }}>
                                </div>
                            </div>

                            <div class="col-md-6 documento-pf" {{ old('tipo_documento', $establishment->tipo_documento ?? 'pj') == 'pj' ? 'style=display:none' : '' }}>
                                <div class="mb-3">
                                    <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg cpf-mask" id="cpf" name="cpf" value="{{ old('cpf', $establishment->cpf) }}" placeholder="000.000.000-00" {{ old('tipo_documento', $establishment->tipo_documento ?? 'pj') == 'pf' ? 'required' : '' }}>
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
                                    <input type="text" class="form-control form-control-lg phone-mask" id="telefone" name="telefone" value="{{ old('telefone', $establishment->telefone) }}" placeholder="(00) 00000-0000" required>
                                </div>
                            </div>
                        </div>

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
                                    <select class="form-select form-select-lg" id="estado" name="estado" required>
                                        <option value="">Selecione o estado</option>
                                        @foreach(\App\Models\Estado::orderBy('nome')->get() as $estado)
                                            <option value="{{ $estado->sigla }}" {{ old('estado', $establishment->estado) == $estado->sigla ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Materiais</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                    <div class="form-text text-sm">Tamanho máximo do arquivo: 15MB. Recomendado: Fundo transparente, formato PNG ou SVG.</div>
                                    @if ($establishment->logo)
                                        <div class="mt-2">
                                            <label>Logo atual:</label>
                                            <div class="mt-1">
                                                <img src="{{ asset('storage/' . $establishment->logo) }}" alt="Logo atual" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Imagem Principal</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <div class="form-text text-sm">Tamanho máximo do arquivo: 15MB. Imagem principal do estabelecimento.</div>
                                    @if ($establishment->image)
                                        <div class="mt-2">
                                            <label>Imagem atual:</label>
                                            <div class="mt-1">
                                                <img src="{{ asset('storage/' . $establishment->image) }}" alt="Imagem atual" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Substituindo a seção de QR Codes pelo componente --}}
                        <x-qr-code-manager :qrCodes="$qrCodes" :establishment="$establishment" />

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

{{-- Incluindo o modal de remoção --}}
<x-qr-code-remove-modal />

@push('scripts')
{{-- Utility Scripts --}}
<script src="{{ asset('assets/js/utils/input-masks.js') }}"></script>
<script src="{{ asset('assets/js/utils/cep-lookup.js') }}"></script>
<script src="{{ asset('assets/js/components/qr-code-manager.js') }}"></script>
<script src="{{ asset('assets/js/utils/documento-tipo-toggle.js') }}"></script>
@endpush

@endsection
