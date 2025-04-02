@extends('admin.layouts.app')

@section('title', 'Editar Administrador')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold">Editar Administrador</h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="needs-validation" novalidate>
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

                        @if(isset($isMainAdmin) && $isMainAdmin)
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <span>Este é o administrador principal do sistema e não pode ser excluído.</span>
                                </div>
                            </div>
                        @endif

                        <div class="row g-4">
                            <!-- Informações Pessoais -->
                            <div class="col-12">
                                <h5 class="mb-3">Informações do Administrador</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <h5 class="mb-3 border-top pt-4">Alterar Senha (opcional)</h5>
                                <p class="text-muted">Deixe em branco para manter a senha atual.</p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Nova Senha</label>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control form-control-lg"
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg me-2">Cancelar</a>
                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                        <i class="fas fa-save me-2"></i> Salvar Alterações
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
