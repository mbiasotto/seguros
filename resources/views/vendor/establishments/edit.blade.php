@extends('vendor.layouts.app')

@section('title', 'Editar Estabelecimento')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold">Editar Estabelecimento</h2>
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
                                <!-- Não exibimos o campo de vendedor responsável na área do vendor -->
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

                        <h5 class="border-bottom pb-2 mb-4 fw-bold">Informações Principais</h5>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="nome" class="form-label fw-semibold">Nome do Estabelecimento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="{{ old('nome', $establishment->nome) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email', $establishment->email) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="telefone" class="form-label fw-semibold">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="telefone" name="telefone" value="{{ old('telefone', $establishment->telefone) }}" placeholder="(00) 00000-0000" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4 fw-bold">Endereço</h5>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="endereco" class="form-label fw-semibold">Endereço Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="endereco" name="endereco" value="{{ old('endereco', $establishment->endereco) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="cidade" class="form-label fw-semibold">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="cidade" name="cidade" value="{{ old('cidade', $establishment->cidade) }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-4">
                                    <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="estado" name="estado" maxlength="2" value="{{ old('estado', $establishment->estado) }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-4">
                                    <label for="cep" class="form-label fw-semibold">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="cep" name="cep" value="{{ old('cep', $establishment->cep) }}" placeholder="00000-000" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('vendor.establishments.index') }}" class="btn btn-outline-secondary btn-lg me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
