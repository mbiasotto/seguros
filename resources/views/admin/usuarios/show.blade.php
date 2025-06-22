@extends('admin.layouts.app')

@section('title', 'Visualizar Usuário')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/show.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Visualizar Usuário</h1>
    <div>
        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-primary me-2">
            <i class="fas fa-edit me-2"></i>
            Editar
        </a>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Voltar
        </a>
    </div>
</div>

<div class="row">
    <!-- Informações do Usuário -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Informações Pessoais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nome</label>
                        <p class="fw-medium">{{ $usuario->nome }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">CPF</label>
                        <p class="fw-medium">{{ $usuario->cpf_formatado }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Email</label>
                        <p class="fw-medium">{{ $usuario->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Telefone</label>
                        <p class="fw-medium">{{ $usuario->telefone ?: 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Status</label>
                        <div>
                            @if($usuario->status === 'ativo')
                                <span class="badge bg-success fs-6">Ativo</span>
                            @elseif($usuario->status === 'bloqueado')
                                <span class="badge bg-danger fs-6">Bloqueado</span>
                            @else
                                <span class="badge bg-warning text-dark fs-6">Pendente</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Data de Cadastro</label>
                        <p class="fw-medium">{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Limites de Crédito -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Limites de Crédito</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted">Limite Total</label>
                        <p class="fw-medium fs-5 text-primary">R$ {{ number_format($usuario->limite_total, 2, ',', '.') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted">Limite Disponível</label>
                        <p class="fw-medium fs-5 text-success">R$ {{ number_format($usuario->limite_disponivel, 2, ',', '.') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted">Limite Utilizado</label>
                        <p class="fw-medium fs-5 text-warning">R$ {{ number_format($usuario->limite_total - $usuario->limite_disponivel, 2, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Barra de Progresso -->
                @php
                    $percentualUtilizado = $usuario->limite_total > 0 ? (($usuario->limite_total - $usuario->limite_disponivel) / $usuario->limite_total) * 100 : 0;
                @endphp
                <div class="mb-3">
                    <label class="form-label text-muted">Utilização do Limite</label>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-{{ $percentualUtilizado > 80 ? 'danger' : ($percentualUtilizado > 60 ? 'warning' : 'success') }}"
                             role="progressbar"
                             style="width: {{ $percentualUtilizado }}%">
                        </div>
                    </div>
                    <small class="text-muted">{{ number_format($percentualUtilizado, 1) }}% utilizado</small>
                </div>
            </div>
        </div>

        <!-- Estabelecimentos Vinculados -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Estabelecimentos Vinculados</h5>
            </div>
            <div class="card-body">
                @if($usuario->estabelecimentos && $usuario->estabelecimentos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CNPJ/CPF</th>
                                    <th>Cidade</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuario->estabelecimentos as $estabelecimento)
                                    <tr>
                                        <td>{{ $estabelecimento->nome }}</td>
                                        <td>{{ $estabelecimento->cnpj ?: $estabelecimento->cpf }}</td>
                                        <td>{{ $estabelecimento->cidade }}</td>
                                        <td>
                                            <span class="badge bg-{{ $estabelecimento->status === 'ativo' ? 'success' : 'warning' }}">
                                                {{ ucfirst($estabelecimento->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.estabelecimentos.show', $estabelecimento) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-store fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Nenhum estabelecimento vinculado</h6>
                        <p class="text-muted">Este usuário ainda não possui estabelecimentos vinculados.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar com Ações e Informações Adicionais -->
    <div class="col-lg-4">
        <!-- Ações Rápidas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Ações Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button"
                            class="btn btn-outline-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#statusModal">
                        <i class="fas fa-edit me-2"></i>
                        Alterar Status
                    </button>
                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-pencil-alt me-2"></i>
                        Editar Informações
                    </a>
                    <button type="button"
                            class="btn btn-outline-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>
                        Excluir Usuário
                    </button>
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
    </div>
</div>

<!-- Modal de Alteração de Status -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Status do Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.usuarios.update-status', $usuario) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Novo Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="ativo" {{ $usuario->status === 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="bloqueado" {{ $usuario->status === 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                            <option value="pendente" {{ $usuario->status === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Alterar Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o usuário <strong>{{ $usuario->nome }}</strong>?</p>
                <p class="text-muted">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
