@extends('admin.layouts.app')

@section('title', 'Administradores')

@section('content')
<div class="page-header">
    <h1 class="page-title">Administradores</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Nome ou email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="">Todos</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="order_by" class="form-label">Ordenar por</label>
            <select class="form-select" id="order_by" name="order_by">
                <option value="name" {{ request('order_by') == 'name' || !request('order_by') ? 'selected' : '' }}>Nome</option>
                <option value="email" {{ request('order_by') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Data de cadastro</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

@if($users->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-user-shield text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhum administrador encontrado</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Não existem administradores que correspondam aos critérios de busca.</p>
            <div class="mt-4">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto btn-auto">
                    <i class="fas fa-plus"></i>
                    <span>Adicionar Administrador</span>
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
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-success">Ativo</span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button
                                            type="button"
                                            class="btn action-btn"
                                            data-delete-url="{{ route('admin.users.destroy', $user) }}"
                                            data-delete-title="Excluir Administrador"
                                            data-delete-message="Tem certeza que deseja excluir o administrador '{{ $user->name }}'?"
                                            data-delete-confirm="Sim, Excluir"
                                            data-delete-cancel="Cancelar"
                                            data-bs-toggle="tooltip"
                                            title="Excluir"
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

    <x-pagination :paginator="$users" />

@endif
@endsection

@push('scripts')
@endpush
