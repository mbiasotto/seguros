@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Estabelecimentos</h1>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('admin.establishments.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
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

    @if($establishments->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-store text-muted" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Nenhum estabelecimento cadastrado</h4>
                <p class="text-muted">Clique no botão "Novo" para começar.</p>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Vendedor</th>
                            <th>Cidade/Estado</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($establishments as $establishment)
                            <tr>
                                <td class="fw-medium">{{ $establishment->nome }}</td>
                                <td>{{ $establishment->vendor->nome }}</td>
                                <td class="text-muted">{{ $establishment->cidade }}/{{ $establishment->estado }}</td>
                                <td>
                                    <span class="badge bg-{{ $establishment->ativo ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                        {{ $establishment->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.establishments.edit', $establishment) }}" class="btn btn-sm btn-outline-primary me-2 d-inline-flex align-items-center gap-2">
                                            <i class="fas fa-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.establishments.destroy', $establishment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este estabelecimento?')">
                                                <i class="fas fa-trash"></i> Excluir
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
