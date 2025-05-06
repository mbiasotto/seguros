@extends('admin.layouts.app')

@section('title', 'Documentos Pendentes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/empty-state.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Documentos Pendentes</h1>
                <div>
                    <a href="{{ route('admin.establishments.documents.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i> Ver Todos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.establishments.documents.index') ? 'active' : '' }}" href="{{ route('admin.establishments.documents.index') }}">Todos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.establishments.documents.pending') ? 'active' : '' }}" href="{{ route('admin.establishments.documents.pending') }}">Pendentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.establishments.documents.approved') ? 'active' : '' }}" href="{{ route('admin.establishments.documents.approved') }}">Aprovados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.establishments.documents.rejected') ? 'active' : '' }}" href="{{ route('admin.establishments.documents.rejected') }}">Rejeitados</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            @if($pendingDocuments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Estabelecimento</th>
                                <th>Enviado em</th>
                                <th>Vendor</th>
                                <th>Status</th>
                                <th width="200">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingDocuments as $document)
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
                                        <span class="badge bg-warning text-dark">Pendente</span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.establishments.documents.view', $document) }}" class="btn btn-sm btn-outline-secondary me-1" target="_blank" title="Visualizar documento">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                            <a href="{{ route('admin.establishments.documents.show', $document) }}" class="btn btn-sm btn-primary me-1" title="Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.establishments.documents.approve', $document) }}" method="POST" class="d-inline me-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Tem certeza que deseja aprovar este documento?')" title="Aprovar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $document->id }}" title="Rejeitar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <!-- Modal de Rejeição -->
                                        <div class="modal fade" id="rejectModal{{ $document->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $document->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel{{ $document->id }}">Rejeitar Documento</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.establishments.documents.reject', $document) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="notes{{ $document->id }}" class="form-label">Motivo da Rejeição <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" id="notes{{ $document->id }}" name="notes" rows="3" required></textarea>
                                                                <div class="form-text">Informe o motivo da rejeição do documento.</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-danger">Rejeitar Documento</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center py-3">
                    {{ $pendingDocuments->links() }}
                </div>
            @else
                <div class="empty-state p-5">
                    <div class="empty-state-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="fw-bold">Nenhum documento pendente</h3>
                    <p class="text-muted">Não há documentos pendentes de aprovação no momento.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
