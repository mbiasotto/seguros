@extends('vendor.layouts.app')

@section('title', 'Meu Perfil')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Meu Perfil</h1>
                <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para o Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="border-bottom pb-2 mb-4 fw-bold">Informações Pessoais</h5>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                        </div>
                    @endif

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

                    <form action="{{ route('vendor.profile.update') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Informações Pessoais -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label fw-semibold">Nome</label>
                                    <input type="text" class="form-control form-control-lg" id="nome" value="{{ $vendor->nome }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">E-mail</label>
                                    <input type="email" class="form-control form-control-lg" id="email" value="{{ $vendor->email }}" disabled>
                                </div>
                            </div>

                            <!-- Informações de Contato -->
                            <div class="col-12">
                                <h5 class="mb-3 fw-bold">Informações de Contato</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label fw-semibold">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $vendor->telefone) }}" required>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="endereco" class="form-label fw-semibold">Endereço</label>
                                    <input type="text" class="form-control form-control-lg @error('endereco') is-invalid @enderror" id="endereco" name="endereco" value="{{ old('endereco', $vendor->endereco) }}">
                                    @error('endereco')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label fw-semibold">Cidade</label>
                                    <input type="text" class="form-control form-control-lg @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade', $vendor->cidade) }}">
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="estado" class="form-label fw-semibold">Estado</label>
                                    <input type="text" class="form-control form-control-lg @error('estado') is-invalid @enderror" id="estado" name="estado" maxlength="2" value="{{ old('estado', $vendor->estado) }}">
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cep" class="form-label fw-semibold">CEP</label>
                                    <input type="text" class="form-control form-control-lg @error('cep') is-invalid @enderror" id="cep" name="cep" value="{{ old('cep', $vendor->cep) }}">
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alterar Senha -->
                            <div class="col-12">
                                <hr class="my-4">
                                <h5 class="mb-3 fw-bold">Alterar Senha</h5>
                                <p class="text-muted small mb-3">Preencha apenas se desejar alterar sua senha</p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Nova Senha</label>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary btn-lg me-2">Cancelar</a>
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
