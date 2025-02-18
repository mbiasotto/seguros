@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Vendedores</h1>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Novo</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($vendors->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Nenhum vendedor cadastrado</h4>
                <p class="text-muted">Clique no botão "Novo Vendedor" para começar.</p>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Cidade/Estado</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendors as $vendor)
                            <tr>
                                <td class="fw-medium">{{ $vendor->nome }}</td>
                                <td>{{ $vendor->email }}</td>
                                <td>{{ $vendor->telefone }}</td>
                                <td>{{ $vendor->cidade }}/{{ $vendor->estado }}</td>
                                <td>
                                    <span class="badge bg-{{ $vendor->ativo ? 'success' : 'danger' }} rounded-pill">
                                        {{ $vendor->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este vendedor?')">
                                                <i class="bi bi-trash"></i> Excluir
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
    @endif
</div>
@endsection
