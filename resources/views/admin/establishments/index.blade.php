@extends('admin.layouts.app')

@section('title', 'Estabelecimentos')

@section('content')
<div class="page-header">
    <h1 class="page-title">Estabelecimentos</h1>
    <a href="{{ route('admin.establishments.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.establishments.index') }}" method="GET" class="row g-3">
        <div class="col-md-2">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Nome, email ou cidade..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select class="form-select" id="cliente_id" name="cliente_id">
                <option value="">Todos os clientes</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="category_id" class="form-label">Categoria</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">Todas as categorias</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="tipo_documento" class="form-label">Tipo de Pessoa</label>
            <select class="form-select" id="tipo_documento" name="tipo_documento">
                <option value="">Todos</option>
                <option value="pj" {{ request('tipo_documento') == 'pj' ? 'selected' : '' }}>Pessoa Jurídica</option>
                <option value="pf" {{ request('tipo_documento') == 'pf' ? 'selected' : '' }}>Pessoa Física</option>
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
                <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Data de cadastro</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
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
    <div class="card border-0 shadow-sm mobile-table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>RESPONSÁVEL</th>
                        <th>CATEGORIA</th>
                        <th>Tipo</th>
                        <th>Cidade/Estado</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($establishments as $establishment)
                        <tr>
                            <td class="fw-medium">{{ $establishment->nome_fantasia ?? $establishment->razao_social }}</td>
                            <td>{{ $establishment->criadoPorAdmin->name ?? 'N/A' }}</td>
                            <td>{{ $establishment->categoria->nome ?? 'Sem categoria' }}</td>
                            <td>
                                @if($establishment->cnpj)
                                    <span class="badge bg-secondary">Pessoa Jurídica</span>
                                @else
                                    <span class="badge bg-info">Pessoa Física</span>
                                @endif
                            </td>
                            <td>{{ $establishment->cidade }}/{{ $establishment->estado }}</td>
                            <td>{{ $establishment->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($establishment->status == 'ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.establishments.edit', $establishment) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn action-btn"
                                        data-delete-url="{{ route('admin.establishments.destroy', $establishment) }}"
                                        data-delete-title="Excluir Estabelecimento"
                                        data-delete-message="Tem certeza que deseja excluir o estabelecimento '{{ $establishment->nome_fantasia ?? $establishment->razao_social }}'?"
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

    <x-pagination :paginator="$establishments" />

@endif
@endsection

@push('scripts')
@endpush
