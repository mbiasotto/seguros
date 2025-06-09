@extends('establishment.layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Meu Perfil</h1>
        @include('admin.components.back-button', ['route' => route('establishment.dashboard')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
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

                    <form action="{{ route('establishment.profile.update') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações do Estabelecimento</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome do Estabelecimento</label>
                                    <input type="text" class="form-control form-control-lg" id="nome" value="{{ $establishment->nome }}" disabled readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control form-control-lg" id="email" value="{{ $establishment->email }}" disabled readonly>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações de Localização</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control form-control-lg" id="endereco" value="{{ $establishment->endereco }}" disabled readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control form-control-lg" id="cidade" value="{{ $establishment->cidade }}" disabled readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control form-control-lg" id="estado" value="{{ $establishment->estado }}" disabled readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control form-control-lg" id="cep" value="{{ $establishment->cep }}" disabled readonly>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações de Contato</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg phone-mask @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $establishment->telefone) }}" placeholder="(00) 00000-0000" required>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Espaço para futuras opções -->
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('establishment.dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
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
