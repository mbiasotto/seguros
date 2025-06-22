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

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">Informações do Estabelecimento</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoria_id" class="form-label">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
                                        <option value="">Selecione uma categoria</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('categoria_id', $establishment->categoria_id) == $category->id) ? 'selected' : '' }}>
                                                {{ $category->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Selecione o status</option>
                                        <option value="ativo" {{ old('status', $establishment->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                        <option value="pendente" {{ old('status', $establishment->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="bloqueado" {{ old('status', $establishment->status) == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="razao_social" class="form-label">Razão Social <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('razao_social') is-invalid @enderror" id="razao_social" name="razao_social" value="{{ old('razao_social', $establishment->razao_social) }}" required>
                                    @error('razao_social')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                                    <input type="text" class="form-control form-control-lg @error('nome_fantasia') is-invalid @enderror" id="nome_fantasia" name="nome_fantasia" value="{{ old('nome_fantasia', $establishment->nome_fantasia) }}">
                                    @error('nome_fantasia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cnpj" class="form-label">CNPJ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg cnpj-mask @error('cnpj') is-invalid @enderror" id="cnpj" name="cnpj" value="{{ old('cnpj', $establishment->cnpj) }}" placeholder="00.000.000/0000-00" required>
                                    @error('cnpj')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $establishment->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg phone-mask @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $establishment->telefone) }}" placeholder="(00) 00000-0000" required>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">Endereço</h5>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg cep-mask @error('cep') is-invalid @enderror" id="cep" name="cep" value="{{ old('cep', $establishment->cep) }}" placeholder="00000-000" required>
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label for="endereco" class="form-label">Endereço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('endereco') is-invalid @enderror" id="endereco" name="endereco" value="{{ old('endereco', $establishment->endereco) }}" required>
                                    @error('endereco')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control form-control-lg @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $establishment->numero) }}">
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bairro" class="form-label">Bairro <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ old('bairro', $establishment->bairro) }}" required>
                                    @error('bairro')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade', $establishment->cidade) }}" required>
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                        <option value="">Selecione o estado</option>
                                        <option value="AC" {{ old('estado', $establishment->estado) == 'AC' ? 'selected' : '' }}>Acre</option>
                                        <option value="AL" {{ old('estado', $establishment->estado) == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                        <option value="AP" {{ old('estado', $establishment->estado) == 'AP' ? 'selected' : '' }}>Amapá</option>
                                        <option value="AM" {{ old('estado', $establishment->estado) == 'AM' ? 'selected' : '' }}>Amazonas</option>
                                        <option value="BA" {{ old('estado', $establishment->estado) == 'BA' ? 'selected' : '' }}>Bahia</option>
                                        <option value="CE" {{ old('estado', $establishment->estado) == 'CE' ? 'selected' : '' }}>Ceará</option>
                                        <option value="DF" {{ old('estado', $establishment->estado) == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                        <option value="ES" {{ old('estado', $establishment->estado) == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                        <option value="GO" {{ old('estado', $establishment->estado) == 'GO' ? 'selected' : '' }}>Goiás</option>
                                        <option value="MA" {{ old('estado', $establishment->estado) == 'MA' ? 'selected' : '' }}>Maranhão</option>
                                        <option value="MT" {{ old('estado', $establishment->estado) == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                        <option value="MS" {{ old('estado', $establishment->estado) == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                        <option value="MG" {{ old('estado', $establishment->estado) == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                        <option value="PA" {{ old('estado', $establishment->estado) == 'PA' ? 'selected' : '' }}>Pará</option>
                                        <option value="PB" {{ old('estado', $establishment->estado) == 'PB' ? 'selected' : '' }}>Paraíba</option>
                                        <option value="PR" {{ old('estado', $establishment->estado) == 'PR' ? 'selected' : '' }}>Paraná</option>
                                        <option value="PE" {{ old('estado', $establishment->estado) == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                        <option value="PI" {{ old('estado', $establishment->estado) == 'PI' ? 'selected' : '' }}>Piauí</option>
                                        <option value="RJ" {{ old('estado', $establishment->estado) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                        <option value="RN" {{ old('estado', $establishment->estado) == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                        <option value="RS" {{ old('estado', $establishment->estado) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                        <option value="RO" {{ old('estado', $establishment->estado) == 'RO' ? 'selected' : '' }}>Rondônia</option>
                                        <option value="RR" {{ old('estado', $establishment->estado) == 'RR' ? 'selected' : '' }}>Roraima</option>
                                        <option value="SC" {{ old('estado', $establishment->estado) == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                        <option value="SP" {{ old('estado', $establishment->estado) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                                        <option value="SE" {{ old('estado', $establishment->estado) == 'SE' ? 'selected' : '' }}>Sergipe</option>
                                        <option value="TO" {{ old('estado', $establishment->estado) == 'TO' ? 'selected' : '' }}>Tocantins</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.establishments.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="fas fa-save me-2"></i> Salvar
                            </button>
                            </div>
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
