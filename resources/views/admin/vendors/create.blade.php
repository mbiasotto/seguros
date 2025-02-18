@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0">Novo Vendedor</h1>
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.vendors.store') }}" method="POST" class="needs-validation" novalidate>
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

                        <div class="row g-4">
                            <!-- Informações Pessoais -->
                            <div class="col-12">
                                <h5 class="mb-3">Informações Pessoais</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" name="nome" value="{{ old('nome') }}" 
                                           placeholder="Digite o nome" required>
                                    <label for="nome">Nome</label>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" 
                                           placeholder="Digite o email" required>
                                    <label for="email">E-mail</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="Digite a senha" required>
                                    <label for="password">Senha</label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="Confirme a senha" required>
                                    <label for="password_confirmation">Confirmar Senha</label>
                                </div>
                            </div>

                            <!-- Informações de Contato -->
                            <div class="col-12">
                                <h5 class="mb-3">Informações de Contato</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                           id="telefone" name="telefone" value="{{ old('telefone') }}" 
                                           placeholder="Digite o telefone" required>
                                    <label for="telefone">Telefone</label>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                                           id="cep" name="cep" value="{{ old('cep') }}" 
                                           placeholder="Digite o CEP" required>
                                    <label for="cep">CEP</label>
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                           id="cidade" name="cidade" value="{{ old('cidade') }}" 
                                           placeholder="Digite a cidade" required>
                                    <label for="cidade">Cidade</label>
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('estado') is-invalid @enderror" 
                                            id="estado" name="estado" required>
                                        <option value="">Selecione o estado</option>
                                        <option value="AC" {{ old('estado') == 'AC' ? 'selected' : '' }}>Acre</option>
                                        <option value="AL" {{ old('estado') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                        <!-- Add other states -->
                                    </select>
                                    <label for="estado">Estado</label>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">Ativo</label>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
