@extends('admin.layouts.app')

@section('title', 'QR Codes')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<style>
    .filter-container {
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .filter-container .form-label {
        font-weight: 500;
    }
    .table-container {
        overflow-x: auto;
    }
    .pagination-info {
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">QR Codes</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.qr-codes.pdf') }}" class="btn btn-success d-flex align-items-center gap-2">
            <i class="fas fa-file-pdf"></i>
            <span>Gerar PDF para Impressão</span>
        </a>
        <a href="{{ route('admin.qr-codes.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Novo QR Code</span>
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="{{ route('admin.qr-codes.index') }}" method="GET" class="row g-3">
        <div class="col-md-5">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="ID, título ou descrição..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Todos</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativos</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativos</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="order_by" class="form-label">Ordenar por</label>
            <select class="form-select" id="order_by" name="order_by">
                <option value="id" {{ request('order_by') == 'id' || !request('order_by') ? 'selected' : '' }}>ID</option>
                <option value="title" {{ request('order_by') == 'title' ? 'selected' : '' }}>Título</option>
                <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Data de criação</option>
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

@if($qrCodes->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <i class="fas fa-qrcode text-muted fa-3x mb-3"></i>
            <h4 class="mt-3">Nenhum QR Code cadastrado</h4>
            <p class="text-muted mb-4">Clique no botão "Novo QR Code" para começar.</p>
            <a href="{{ route('admin.qr-codes.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto" style="width: fit-content;">
                <i class="fas fa-plus"></i>
                <span>Novo QR Code</span>
            </a>
        </div>
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-container">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Título</th>
                        <th style="width: 25%;">Link</th>
                        <th style="width: 80px;">Status</th>
                        <th style="width: 120px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($qrCodes as $qrCode)
                        <tr>
                            <td class="text-muted">#{{ $qrCode->id }}</td>
                            <td class="fw-medium">{{ $qrCode->title ?: 'Sem título' }}</td>
                            <td class="text-truncate" style="max-width: 250px;">
                                <small>{{ Str::limit($qrCode->link, 50) }}</small>
                            </td>
                            <td>
                                @if($qrCode->active)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.qr-codes.show', $qrCode) }}" class="btn btn-sm btn-info" title="Visualizar QR Code">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                    <a href="{{ route('admin.qr-codes.download', $qrCode) }}" class="btn btn-sm btn-success" title="Baixar QR Code">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ route('admin.qr-codes.edit', $qrCode) }}" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.qr-codes.destroy', $qrCode) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este QR Code?')" title="Excluir">
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

    <div class="mt-4">
        {{ $qrCodes->links() }}
    </div>
@endif
@endsection
