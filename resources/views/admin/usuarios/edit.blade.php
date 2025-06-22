@extends('admin.layouts.app')

@section('title', 'Editar Usuário')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/form.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Editar Usuário</h1>
    <div>
        <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-eye me-2"></i>
            Visualizar
        </a>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Informações do Usuário</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nome') is-invalid @enderror"
                                   id="nome"
                                   name="nome"
                                   value="{{ old('nome', $usuario->nome) }}"
                                   required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $usuario->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('cpf') is-invalid @enderror"
                                   id="cpf"
                                   name="cpf"
                                   value="{{ old('cpf', $usuario->cpf) }}"
                                   data-mask="000.000.000-00"
                                   required>
                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text"
                                   class="form-control @error('telefone') is-invalid @enderror"
                                   id="telefone"
                                   name="telefone"
                                   value="{{ old('telefone', $usuario->telefone) }}"
                                   data-mask="(00) 00000-0000">
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="limite_total" class="form-label">Limite Total <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number"
                                       class="form-control @error('limite_total') is-invalid @enderror"
                                       id="limite_total"
                                       name="limite_total"
                                       value="{{ old('limite_total', $usuario->limite_total) }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                @error('limite_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Limite atual disponível: R$ {{ number_format($usuario->limite_disponivel, 2, ',', '.') }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Selecione o status</option>
                                <option value="ativo" {{ old('status', $usuario->status) === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="bloqueado" {{ old('status', $usuario->status) === 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                                <option value="pendente" {{ old('status', $usuario->status) === 'pendente' ? 'selected' : '' }}>Pendente</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar com Informações Adicionais -->
    <div class="col-lg-4">
        <!-- Informações de Limite -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Situação Atual dos Limites</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Limite Total Atual</label>
                    <p class="fw-medium fs-5 text-primary mb-0">R$ {{ number_format($usuario->limite_total, 2, ',', '.') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Limite Disponível</label>
                    <p class="fw-medium fs-5 text-success mb-0">R$ {{ number_format($usuario->limite_disponivel, 2, ',', '.') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Limite Utilizado</label>
                    <p class="fw-medium fs-5 text-warning mb-0">R$ {{ number_format($usuario->limite_total - $usuario->limite_disponivel, 2, ',', '.') }}</p>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Ao alterar o limite total, a diferença será adicionada ou subtraída do limite disponível.</small>
                </div>
            </div>
        </div>

        <!-- Informações Administrativas -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Informações Administrativas</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Criado por</label>
                    <p class="fw-medium">{{ $usuario->criadoPorAdmin->name ?? 'Sistema' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Data de Criação</label>
                    <p class="fw-medium">{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Última Atualização</label>
                    <p class="fw-medium">{{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Estabelecimentos Vinculados -->
        @if($usuario->estabelecimentos && $usuario->estabelecimentos->count() > 0)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Estabelecimentos Vinculados</h5>
            </div>
            <div class="card-body">
                @foreach($usuario->estabelecimentos as $estabelecimento)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">{{ $estabelecimento->nome }}</h6>
                            <small class="text-muted">{{ $estabelecimento->cidade }}</small>
                        </div>
                        <span class="badge bg-{{ $estabelecimento->status === 'ativo' ? 'success' : 'warning' }}">
                            {{ ucfirst($estabelecimento->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validação personalizada para CPF
    (function() {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endpush
