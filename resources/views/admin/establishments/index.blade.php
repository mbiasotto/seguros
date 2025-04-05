@extends('admin.layouts.app')

@section('title', 'Estabelecimentos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/components/empty-state.css') }}">
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">Estabelecimentos</h1>
    <a href="{{ route('admin.establishments.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.establishments.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Nome, email ou cidade..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label for="vendor_id" class="form-label">Vendedor</label>
            <select class="form-select" id="vendor_id" name="vendor_id">
                <option value="">Todos os vendedores</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->nome }}</option>
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
                <option value="id" {{ request('order_by') == 'id' || !request('order_by') ? 'selected' : '' }}>ID</option>
                <option value="nome" {{ request('order_by') == 'nome' ? 'selected' : '' }}>Nome</option>
                <option value="cidade" {{ request('order_by') == 'cidade' ? 'selected' : '' }}>Cidade</option>
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

@if($establishments->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-store text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhum estabelecimento cadastrado</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Você ainda não possui estabelecimentos cadastrados no sistema. Adicione seu primeiro estabelecimento para começar a gerenciar seus negócios.</p>
            <div class="mt-4">
                <a href="{{ route('admin.establishments.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto" style="width: fit-content;">
                    <i class="fas fa-plus"></i>
                    <span>Adicionar Estabelecimento</span>
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
                        <th>Vendedor</th>
                        <th>Email</th>
                        <th>Cidade/Estado</th>
                        <th>Status</th>
                        <th width="120">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($establishments as $establishment)
                        <tr>
                            <td class="fw-medium">{{ $establishment->nome }}</td>
                            <td>{{ $establishment->vendor->nome }}</td>
                            <td>{{ $establishment->email }}</td>
                            <td>{{ $establishment->cidade }}/{{ $establishment->estado }}</td>
                            <td>
                                @if($establishment->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.establishments.edit', $establishment) }}" class="btn btn-edit" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        data-delete-url="{{ route('admin.establishments.destroy', $establishment) }}"
                                        data-delete-title="Excluir Estabelecimento"
                                        data-delete-message="Tem certeza que deseja excluir o estabelecimento '{{ $establishment->nome }}'?"
                                        data-delete-confirm="Sim, Excluir"
                                        data-delete-cancel="Cancelar"
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

    @if(isset($establishments->links))
    <div class="mt-4">
        {{ $establishments->links() }}
    </div>
    @endif
@endif
@endsection
