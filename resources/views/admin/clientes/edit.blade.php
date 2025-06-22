@extends('admin.layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Editar Cliente</h1>
        @include('admin.components.back-button', ['route' => route('admin.clientes.index')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST" class="needs-validation" novalidate>
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
                            <!-- Informações Pessoais -->
                            <div class="col-12">
                                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">Informações do Cliente</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('nome') is-invalid @enderror"
                                           id="nome" name="nome" value="{{ old('nome', $cliente->nome) }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $cliente->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg cpf-mask @error('cpf') is-invalid @enderror"
                                           id="cpf" name="cpf" value="{{ old('cpf', $cliente->cpf) }}" placeholder="000.000.000-00" required>
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control form-control-lg phone-mask @error('telefone') is-invalid @enderror"
                                           id="telefone" name="telefone" value="{{ old('telefone', $cliente->telefone) }}" placeholder="(00) 00000-0000">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="limite_total" class="form-label">Limite Total <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control form-control-lg @error('limite_total') is-invalid @enderror"
                                               id="limite_total" name="limite_total" value="{{ old('limite_total', $cliente->limite_total) }}" step="0.01" min="0" required>
                                    </div>
                                    <small class="form-text text-muted">Limite disponível atual: R$ {{ number_format($cliente->limite_disponivel, 2, ',', '.') }}</small>
                                    @error('limite_total')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('status') is-invalid @enderror"
                                           id="status" name="status" required>
                                        <option value="">Selecione o status</option>
                                        <option value="ativo" {{ old('status', $cliente->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                        <option value="pendente" {{ old('status', $cliente->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="bloqueado" {{ old('status', $cliente->status) == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <h2 class="fw-bold text-lg mb-3 border-top pt-4">Alterar Senha (opcional)</h2>
                                <p class="text-muted text-sm mb-3">Deixe em branco para manter a senha atual.</p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               id="password" name="password">
                                        <button type="button" class="btn btn-secondary" id="generatePassword">
                                            <i class="fas fa-key me-1"></i> Gerar
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="text" class="form-control form-control-lg"
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-times me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-save me-2"></i> Salvar
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
<script src="{{ asset('assets/admin/js/utils/password-generator.js') }}"></script>
<script src="{{ asset('assets/js/utils/input-masks.js') }}"></script>
@endpush
