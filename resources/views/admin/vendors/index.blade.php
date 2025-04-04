@extends('admin.layouts.app')

@section('title', 'Vendedores')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
<style>
    .filter-container {
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .filter-container .form-label {
        font-weight: 500;
    }
    .table-container {
        overflow-x: auto;
    }
    .pagination-info {
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">Vendedores</h1>
    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.vendors.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Nome, email, telefone ou cidade..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado">
                <option value="">Todos</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Todos</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativos</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativos</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="order_by" class="form-label">Ordenar por</label>
            <select class="form-select" id="order_by" name="order_by">
                <option value="nome" {{ request('order_by') == 'nome' || !request('order_by') ? 'selected' : '' }}>Nome</option>
                <option value="email" {{ request('order_by') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="cidade" {{ request('order_by') == 'cidade' ? 'selected' : '' }}>Cidade</option>
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

@if($vendors->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-users text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhum vendedor cadastrado</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Você ainda não possui vendedores cadastrados no sistema. Adicione seu primeiro vendedor para começar a gerenciar sua equipe de vendas.</p>
            <div class="mt-4">
                <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto" style="width: fit-content;">
                    <i class="fas fa-plus"></i>
                    <span>Novo</span>
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
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cidade/Estado</th>
                        <th>Status</th>
                        <th>Último Acesso</th>
                        <th width="160">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->nome }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->telefone }}</td>
                            <td>{{ $vendor->cidade }}/{{ $vendor->estado }}</td>
                            <td>
                                @if($vendor->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                @if($vendor->lastAccess())
                                    {{ $vendor->lastAccess()->created_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">Nunca acessou</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-edit" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.vendors.access-logs', $vendor) }}" class="btn btn-info" title="Histórico de Acessos">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este vendedor?')" title="Excluir">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($vendors->links))
    <div class="mt-4">
        {{ $vendors->links() }}
    </div>
    @endif
@endif
@endsection
