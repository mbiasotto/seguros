@extends('admin.layouts.app')

@section('title', 'Estabelecimentos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">Estabelecimentos</h1>
    <a href="{{ route('admin.establishments.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo Estabelecimento</span>
    </a>
</div>

@if($establishments->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <i class="fas fa-store text-muted fa-3x mb-3"></i>
            <h4 class="mt-3">Nenhum estabelecimento cadastrado</h4>
            <p class="text-muted mb-4">Clique no botão "Novo Estabelecimento" para começar.</p>
            <a href="{{ route('admin.establishments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Estabelecimento
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
                                    <a href="{{ route('admin.establishments.edit', $establishment) }}" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.establishments.destroy', $establishment) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este estabelecimento?')" title="Excluir">
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

    @if(isset($establishments->links))
    <div class="mt-4">
        {{ $establishments->links() }}
    </div>
    @endif
@endif
@endsection
