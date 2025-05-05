@extends('admin.layouts.app')

@section('title', 'Documentos dos Estabelecimentos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Documentos dos Estabelecimentos</h1>
        <div><!-- Espaço para botões, caso necessário no futuro --></div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="row d-flex justify-content-between align-items-center mb-3">
                <div class="col-md-8">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.establishments.documents.index') && !request()->has('status') ? 'active' : '' }}" href="{{ route('admin.establishments.documents.index') }}">Todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.establishments.documents.pending') || request('status') === 'pending' ? 'active' : '' }}" href="{{ route('admin.establishments.documents.pending') }}">Pendentes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.establishments.documents.approved') || request('status') === 'approved' ? 'active' : '' }}" href="{{ route('admin.establishments.documents.approved') }}">Aprovados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.establishments.documents.rejected') || request('status') === 'rejected' ? 'active' : '' }}" href="{{ route('admin.establishments.documents.rejected') }}">Rejeitados</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('admin.establishments.documents.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar por estabelecimento..." name="search" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($allDocuments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Estabelecimento</th>
                                <th>Tipo</th>
                                <th>Data de Envio</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allDocuments as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $document->establishment->nome }}</h6>
                                                <small class="text-muted">{{ $document->establishment->cidade }}/{{ $document->establishment->estado }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $document->completed_at ? $document->completed_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $document->establishment->vendor->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($document->document_approved && $document->document_approved_at)
                                            <span class="badge bg-success">Aprovado</span>
                                        @elseif(!$document->document_approved && $document->document_approved_at)
                                            <span class="badge bg-danger">Rejeitado</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pendente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.establishments.documents.show', $document) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($document->status == 'pending')
                                            <button
                                                type="button"
                                                class="btn action-btn approve-document"
                                                data-id="{{ $document->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Aprovar"
                                            >
                                                <i class="fas fa-check"></i>
                                            </button>

                                            <button
                                                type="button"
                                                class="btn action-btn reject-document"
                                                data-id="{{ $document->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Rejeitar"
                                            >
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @endif

                                            <button
                                                type="button"
                                                class="btn action-btn"
                                                data-delete-url="{{ route('admin.establishments.documents.destroy', $document) }}"
                                                data-delete-title="Excluir Documento"
                                                data-delete-message="Tem certeza que deseja excluir este documento?"
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
                <div class="d-flex justify-content-center py-3">
                    {{ $allDocuments->links() }}
                </div>
            @else
                <div class="empty-state p-5">
                    <div class="empty-state-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="fw-bold">Nenhum documento encontrado</h3>
                    <p class="text-muted">Não foram encontrados documentos com os filtros selecionados.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar tooltips do Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            });
        });

        // Outros scripts existentes
        // ... existing code ...
    });
</script>
@endpush
