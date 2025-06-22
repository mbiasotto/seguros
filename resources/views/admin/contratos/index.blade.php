@extends('admin.layouts.app')

@section('title', 'Contratos')

@section('content')
<div class="page-header">
    <h1 class="page-title">Contratos</h1>
    <a href="{{ route('admin.contratos.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.contratos.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Número contrato ou nome..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="">Todos</option>
                <option value="pendente_cpfl" {{ request('status') == 'pendente_cpfl' ? 'selected' : '' }}>Pendente CPFL</option>
                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="site" {{ request('tipo') == 'site' ? 'selected' : '' }}>Site</option>
                <option value="avulso" {{ request('tipo') == 'avulso' ? 'selected' : '' }}>Avulso</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="order_by" class="form-label">Ordenar por</label>
            <select class="form-select" id="order_by" name="order_by">
                <option value="created_at" {{ request('order_by') == 'created_at' || !request('order_by') ? 'selected' : '' }}>Data de criação</option>
                <option value="numero_contrato" {{ request('order_by') == 'numero_contrato' ? 'selected' : '' }}>Número</option>
                <option value="status" {{ request('order_by') == 'status' ? 'selected' : '' }}>Status</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($contratos->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-file-contract text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhum contrato encontrado</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Não existem contratos que correspondam aos critérios de busca.</p>
            <div class="mt-4">
                <a href="{{ route('admin.contratos.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto btn-auto">
                    <i class="fas fa-plus"></i>
                    <span>Criar Primeiro Contrato</span>
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
                        <th>Número</th>
                        <th>Usuário</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Score Inicial</th>
                        <th>Limite Inicial</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contratos as $contrato)
                        <tr>
                            <td class="fw-bold">{{ $contrato->numero_contrato }}</td>
                            <td>
                                <div>
                                    <strong>{{ $contrato->usuario->nome }}</strong><br>
                                    <small class="text-muted">{{ $contrato->usuario->cpf_formatado }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $contrato->tipo == 'site' ? 'info' : 'secondary' }}">
                                    {{ ucfirst($contrato->tipo) }}
                                </span>
                            </td>
                            <td>
                                @if($contrato->status === 'ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @elseif($contrato->status === 'pendente_cpfl')
                                    <span class="badge bg-warning text-dark">Pendente CPFL</span>
                                @else
                                    <span class="badge bg-danger">Cancelado</span>
                                @endif
                            </td>
                            <td>{{ $contrato->score_inicial ?? 'N/A' }}</td>
                            <td>R$ {{ number_format($contrato->limite_inicial, 2, ',', '.') }}</td>
                            <td>{{ $contrato->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.contratos.show', $contrato) }}"
                                       class="btn btn-sm btn-outline-primary" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($contrato->status === 'pendente_cpfl')
                                        <a href="{{ route('admin.contratos.edit', $contrato) }}"
                                           class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if($contratos->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $contratos->links() }}
        </div>
    @endif
@endif
@endsection
