@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Vendedores</h1>
            <p class="text-muted">Gerencie todos os vendedores cadastrados</p>
        </div>
        <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i>
            <span>Novo Vendedor</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->nome }}</td>
                            <td class="text-muted">{{ $vendor->email }}</td>
                            <td class="text-muted">{{ $vendor->telefone }}</td>
                            <td>
                                <span class="badge {{ $vendor->ativo ? 'bg-success' : 'bg-danger' }}">
                                    {{ $vendor->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-outline-info me-2">
                                        <i class="fas fa-edit"></i>
                                        <span>Editar</span>
                                    </a>
                                    <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir este vendedor?')">
                                            <i class="fas fa-trash"></i>
                                            <span>Excluir</span>
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

    <div class="mt-4">
        {{ $vendors->links() }}
    </div>
</div>
@endsection
