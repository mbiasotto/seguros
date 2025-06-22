@extends('admin.layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="page-header">
    <h1 class="page-title">Clientes</h1>
    <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.clientes.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Nome, email ou CPF..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="">Todos</option>
                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="bloqueado" {{ request('status') == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="order_by" class="form-label">Ordenar por</label>
            <select class="form-select" id="order_by" name="order_by">
                <option value="nome" {{ request('order_by') == 'nome' || !request('order_by') ? 'selected' : '' }}>Nome</option>
                <option value="email" {{ request('order_by') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Data de cadastro</option>
                <option value="status" {{ request('order_by') == 'status' ? 'selected' : '' }}>Status</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

@if($clientes->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-users text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhum cliente encontrado</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Não existem clientes que correspondam aos critérios de busca.</p>
            <div class="mt-4">
                <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto btn-auto">
                    <i class="fas fa-plus"></i>
                    <span>Adicionar Cliente</span>
                </a>
            </div>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Contrato</th>
                        <th>Score</th>
                        <th>Limite</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->cpf ? substr($cliente->cpf, 0, 3) . '.' . substr($cliente->cpf, 3, 3) . '.' . substr($cliente->cpf, 6, 3) . '-' . substr($cliente->cpf, 9, 2) : 'N/A' }}</td>
                            <td>
                                @if($cliente->contrato)
                                    @if($cliente->contrato->status === 'ativo')
                                        <span class="badge bg-success">Ativo</span>
                                    @elseif($cliente->contrato->status === 'pendente_cpfl')
                                        <span class="badge bg-warning">Pendente</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($cliente->contrato->status) }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Sem contrato</span>
                                @endif
                            </td>
                            <td>
                                @if($cliente->score_atual)
                                    <span class="text-primary fw-bold">{{ $cliente->score_atual }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($cliente->limite_credito_manual)
                                    <span class="text-success fw-bold">R$ {{ number_format($cliente->limite_credito_manual, 2, ',', '.') }}</span>
                                @elseif($cliente->limite_credito_sugerido)
                                    <span class="text-info">R$ {{ number_format($cliente->limite_credito_sugerido, 2, ',', '.') }} <small>(sugerido)</small></span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.clientes.show', $cliente) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    @if(!$cliente->contrato)
                                        <a href="{{ route('admin.contratos.create', ['usuario_id' => $cliente->id]) }}" class="btn action-btn text-success" data-bs-toggle="tooltip" title="Criar Contrato">
                                            <i class="fas fa-file-contract"></i>
                                        </a>
                                    @endif
                                    <button
                                        type="button"
                                        class="btn action-btn"
                                        data-delete-url="{{ route('admin.clientes.destroy', $cliente) }}"
                                        data-delete-title="Excluir Cliente"
                                        data-delete-message="Tem certeza que deseja excluir o cliente '{{ $cliente->nome }}'?"
                                        data-delete-confirm="Sim, Excluir"
                                        data-delete-cancel="Cancelar"
                                        data-bs-toggle="tooltip"
                                        title="Excluir"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-pagination :paginator="$clientes" />

@endif
@endsection

@push('scripts')
@endpush
