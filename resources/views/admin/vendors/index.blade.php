@extends('admin.layouts.app')

@section('title', 'Vendedores')

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">Vendedores</h1>
    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo Vendedor</span>
    </a>
</div>

@if($vendors->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <i class="fas fa-users text-muted fa-3x mb-3"></i>
            <h4 class="mt-3">Nenhum vendedor cadastrado</h4>
            <p class="text-muted mb-4">Clique no botão "Novo Vendedor" para começar.</p>
            <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Vendedor
            </a>
        </div>
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cidade/Estado</th>
                        <th>Status</th>
                        <th width="120">Ações</th>
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
                                <div class="action-buttons">
                                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este vendedor?')" title="Excluir">
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
