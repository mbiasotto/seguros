@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold">Editar Vendedor</h2>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST" class="needs-validation" novalidate>
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

                        <div class="row g-4">
                            <!-- Informações Pessoais -->
                            <div class="col-12">
                                <h5 class="mb-3">Informações Pessoais</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('nome') is-invalid @enderror"
                                           id="nome" name="nome" value="{{ old('nome', $vendor->nome) }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $vendor->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Nova Senha (opcional)</label>
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

                            <!-- Informações de Contato -->
                            <div class="col-12">
                                <h5 class="mb-3">Informações de Contato</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                           id="telefone" name="telefone" value="{{ old('telefone', $vendor->telefone) }}"
                                           placeholder="Digite o telefone" required>
                                    <label for="telefone">Telefone</label>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('cidade') is-invalid @enderror"
                                           id="cidade" name="cidade" value="{{ old('cidade', $vendor->cidade) }}"
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
                                        @foreach(\App\Models\Estado::orderBy('nome')->get() as $estado)
                                            <option value="{{ $estado->sigla }}" {{ old('estado', $vendor->estado) == $estado->sigla ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                        @endforeach
                                    </select>
                                    <label for="estado">Estado</label>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $vendor->ativo) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">Ativo</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary btn-lg me-2">Cancelar</a>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="{{ asset('js/form-utils.js') }}"></script>
@endpush
