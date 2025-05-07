@extends('admin.layouts.app')

@section('title', 'QR Codes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/seguraessa.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">QR Codes</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.qr-codes.statistics.index') }}" class="btn btn-info d-flex align-items-center gap-2">
            <i class="fas fa-chart-line"></i>
            <span class="font-medium">Estatísticas</span>
        </a>
        <!-- Botão para abrir o modal de geração de PDF -->
        <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#pdfRangeModal">
            <i class="fas fa-file-pdf"></i>
            <span class="font-medium">Gerar PDF</span>
        </button>
        <a href="{{ route('admin.qr-codes.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i>
            <span class="font-medium">Novo</span>
        </a>
    </div>
</div>

<!-- Modal para selecionar o intervalo de QR Codes -->
<div class="modal fade" id="pdfRangeModal" tabindex="-1" aria-labelledby="pdfRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfRangeModalLabel">Gerar PDF com intervalo de QR Codes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="{{ route('admin.qr-codes.pdf') }}" method="GET">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="start_id" class="form-label">De (ID inicial):</label>
                            <input type="number" name="start" id="start_id" class="form-control" placeholder="Ex: 101" min="1">
                        </div>
                        <div class="col-md-6">
                            <label for="end_id" class="form-label">Até (ID final):</label>
                            <input type="number" name="end" id="end_id" class="form-control" placeholder="Ex: 200" min="1">
                        </div>
                    </div>
                    <div class="mt-3 text-muted small">
                        Deixe os campos vazios para incluir todos os QR Codes.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success d-flex align-items-center gap-2">
                        <i class="fas fa-file-pdf"></i>
                        <span class="font-medium">Gerar PDF</span>
                    </button>
                </div>
            </form>
        </div>
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
            <button type="submit" class="btn btn-primary w-100 font-medium">Filtrar</button>
        </div>
    </form>
</div>

@if($qrCodes->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-qr-codes">
            <i class="fas fa-qrcode text-muted fa-3x mb-3"></i>
            <h3 class="font-semibold mt-3">Nenhum QR Code cadastrado</h3>
            <p class="text-muted mb-4">Clique no botão "Novo QR Code" para começar.</p>
            <a href="{{ route('admin.qr-codes.create') }}" class="btn btn-primary d-flex align-items-center gap-2 mx-auto" style="width: fit-content;">
                <i class="fas fa-plus"></i>
                <span class="font-medium">Novo QR Code</span>
            </a>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="table-container">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Estabelecimento</th>
                        <th>Criado em</th>
                        <th>Visualizações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($qrCodes as $qrCode)
                        <tr>
                            <td class="text-muted">#{{ $qrCode->id }}</td>
                            <td class="font-medium">{{ $qrCode->title ?: 'Sem título' }}</td>
                            <td class="text-truncate">
                                <small class="text-sm">{{ Str::limit($qrCode->link, 50) }}</small>
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
                                    <a href="{{ route('admin.qr-codes.show', $qrCode) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.qr-codes.edit', $qrCode) }}" class="btn action-btn" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.qr-codes.pdf', $qrCode) }}" target="_blank" class="btn action-btn" data-bs-toggle="tooltip" title="Baixar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn action-btn"
                                        data-delete-url="{{ route('admin.qr-codes.destroy', $qrCode) }}"
                                        data-delete-title="Excluir QR Code"
                                        data-delete-message="Tem certeza que deseja excluir este QR Code?"
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
    </div>

    <div class="mt-4">
        {{ $qrCodes->links() }}
    </div>
@endif
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

        // Outros scripts existentes, se houver
    });
</script>
@endpush
