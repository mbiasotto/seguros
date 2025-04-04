@extends('vendor.layouts.app')

@section('title', 'Documentos dos Estabelecimentos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Documentos dos Estabelecimentos</h1>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light py-3">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vendor.establishments.documents') && !request()->routeIs('vendor.establishments.documents.*') ? 'active' : '' }}" href="{{ route('vendor.establishments.documents') }}">Todos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vendor.establishments.documents.pending') ? 'active' : '' }}" href="{{ route('vendor.establishments.documents.pending') }}">Pendentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vendor.establishments.documents.approved') ? 'active' : '' }}" href="{{ route('vendor.establishments.documents.approved') }}">Aprovados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vendor.establishments.documents.rejected') ? 'active' : '' }}" href="{{ route('vendor.establishments.documents.rejected') }}">Rejeitados</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            @if($documents->isEmpty())
                <div class="empty-state text-center py-5">
                    <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                        <i class="fas fa-file-alt text-primary fa-3x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Nenhum documento encontrado</h3>
                    <p class="text-muted mb-4 col-md-8 mx-auto">Não há documentos de estabelecimentos para exibir nesta categoria.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">Estabelecimento</th>
                                <th scope="col">Data de Envio</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0">{{ $document->establishment->nome }}</h6>
                                                <small class="text-muted">{{ $document->establishment->cidade }}/{{ $document->establishment->estado }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $document->completed_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($document->document_approved === null || ($document->document_approved === false && $document->document_approved_at === null))
                                            <span class="badge bg-warning text-dark">Pendente</span>
                                        @elseif($document->document_approved)
                                            <span class="badge bg-success">Aprovado</span>
                                        @else
                                            <span class="badge bg-danger">Rejeitado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('vendor.establishments.documents.show', $document) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('vendor.establishments.documents.view', $document) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
<form id="filterForm" class="mb-4">
    <div class="form-group">
        <label for="statusFilter">Filtrar por status:</label>
        <select id="statusFilter" class="form-control">
            <option value="">Todos</option>
            <option value="pending">Pendentes</option>
            <option value="approved">Aprovados</option>
            <option value="rejected">Rejeitados</option>
        </select>
    </div>
</form>

<script>
    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('status', status);
        window.location.href = url.toString();
    });
</script>
@endsection
