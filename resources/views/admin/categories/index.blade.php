@extends('admin.layouts.app')

@section('title', 'Categorias')

@section('content')
<div class="page-header">
    <h1 class="page-title">Categorias</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Nova</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-3">
        <div class="col-md-6">
            <label for="search" class="form-label">Buscar por Nome</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Nome da categoria..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label for="order_by" class="form-label">Ordenar por</label>
            <select class="form-select" id="order_by" name="order_by">
                <option value="nome" {{ request('order_by') == 'nome' || !request('order_by') ? 'selected' : '' }}>Nome</option>
                <option value="id" {{ request('order_by') == 'id' ? 'selected' : '' }}>ID</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
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

@if($categories->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-tags text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhuma categoria encontrada</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Não existem categorias cadastradas no sistema.</p>
            <div class="mt-4">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto btn-auto" style="width: fit-content;">
                    <i class="fas fa-plus"></i>
                    <span>Adicionar Categoria</span>
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
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Estabelecimentos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->nome }}</td>
                            <td>{{ $category->establishments->count() }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    @if($category->establishments->count() == 0) {{-- Permite excluir apenas se não houver estabelecimentos associados --}}
                                        <button
                                            type="button"
                                            class="btn action-btn"
                                            data-delete-url="{{ route('admin.categories.destroy', $category) }}"
                                            data-delete-title="Excluir Categoria"
                                            data-delete-message="Tem certeza que deseja excluir a categoria '{{ $category->nome }}'? Esta ação não pode ser desfeita."
                                            data-delete-confirm="Sim, Excluir"
                                            data-delete-cancel="Cancelar"
                                            data-bs-toggle="tooltip"
                                            title="Excluir"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            class="btn action-btn disabled"
                                            data-bs-toggle="tooltip"
                                            title="Não é possível excluir categorias com estabelecimentos vinculados"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endif
@endsection
