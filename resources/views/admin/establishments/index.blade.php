@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Estabelecimentos</h1>
            <p class="text-muted">Gerencie todos os estabelecimentos cadastrados</p>
        </div>
        <a href="{{ route('admin.establishments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i>
            <span>Novo Estabelecimento</span>
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
                        <th>Vendedor</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($establishments as $establishment)
                        <tr>
                            <td>{{ $establishment->nome }}</td>
                            <td class="text-muted">{{ $establishment->vendor->name }}</td>
                            <td class="text-muted">{{ $establishment->cidade }}</td>
                            <td class="text-muted">{{ $establishment->estado }}</td>
                            <td>
                                <span class="badge {{ $establishment->ativo ? 'bg-success' : 'bg-danger' }}">
                                    {{ $establishment->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.establishments.edit', $establishment) }}" class="btn btn-sm btn-outline-info me-2">
                                        <i class="fas fa-edit"></i>
                                        <span>Editar</span>
                                    </a>
                                    <form action="{{ route('admin.establishments.destroy', $establishment) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir este estabelecimento?')">
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
        {{ $establishments->links() }}
    </div>
</div>
@endsection
