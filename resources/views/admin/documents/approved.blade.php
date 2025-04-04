@extends('admin.layouts.app')

@section('title', 'Documentos Aprovados')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Documentos Aprovados</h1>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.establishments.documents') && !request()->routeIs('admin.establishments.documents.*') ? 'active' : '' }}" href="{{ route('admin.establishments.documents.index') }}">Todos</a>
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
            @if($approvedDocuments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Estabelecimento</th>
                                <th>Aprovado em</th>
                                <th>Aprovado por</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedDocuments as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $document->establishment->nome }}</h6>
                                                <small class="text-muted">{{ $document->establishment->cidade }}/{{ $document->establishment->estado }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $document->document_approved_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $document->approvedByUser->name }}</td>
                                    <td>
                                        <span class="badge bg-success">Aprovado</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.establishments.documents.show', $document) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center py-3">
                    {{ $approvedDocuments->links() }}
                </div>
            @else
                <div class="empty-state p-5">
                    <div class="empty-state-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="fw-bold">Nenhum documento aprovado</h3>
                    <p class="text-muted">Não há documentos aprovados no momento.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
