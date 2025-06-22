@extends('admin.layouts.app')

@section('title', 'QR Codes')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/list.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">QR Codes</h1>
    <div>
        <a href="{{ route('admin.qr-codes.acessos') }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-chart-line me-2"></i>
            Ver Acessos
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQrCodeModal">
            <i class="fas fa-plus me-2"></i>
            Novo QR Code
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th>Estabelecimentos</th>
                        <th>Acessos</th>
                        <th>Criado em</th>
                        <th width="120">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($qrCodes as $qrCode)
                        <tr>
                            <td>
                                <span class="badge bg-primary">#{{ $qrCode->id }}</span>
                            </td>
                            <td>
                                <strong>{{ $qrCode->title ?: 'QR Code #' . $qrCode->id }}</strong>
                            </td>
                            <td>
                                <span class="text-muted">{{ Str::limit($qrCode->description, 50) ?: '-' }}</span>
                            </td>
                            <td>
                                <a href="{{ $qrCode->link }}" target="_blank" class="text-primary">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    {{ Str::limit($qrCode->link, 30) }}
                                </a>
                            </td>
                            <td>
                                @if($qrCode->is_active)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $qrCode->establishments_count }}</span>
                                @if($qrCode->max_establishments > 0)
                                    <small class="text-muted">/ {{ $qrCode->max_establishments }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $qrCode->access_logs_count }}</span>
                            </td>
                            <td>{{ $qrCode->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button"
                                            class="btn btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewQrCodeModal{{ $qrCode->id }}"
                                            data-bs-toggle="tooltip"
                                            title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-outline-secondary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editQrCodeModal{{ $qrCode->id }}"
                                            data-bs-toggle="tooltip"
                                            title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-outline-{{ $qrCode->is_active ? 'warning' : 'success' }}"
                                            onclick="toggleStatus({{ $qrCode->id }})"
                                            data-bs-toggle="tooltip"
                                            title="{{ $qrCode->is_active ? 'Desativar' : 'Ativar' }}">
                                        <i class="fas fa-{{ $qrCode->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </div>

                                <!-- Modal de Visualização -->
                                <div class="modal fade" id="viewQrCodeModal{{ $qrCode->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">QR Code #{{ $qrCode->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="mb-3">
                                                            <label class="form-label text-muted">Título</label>
                                                            <p class="fw-medium">{{ $qrCode->title ?: 'Sem título' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-muted">Descrição</label>
                                                            <p class="fw-medium">{{ $qrCode->description ?: 'Sem descrição' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-muted">Link</label>
                                                            <p class="fw-medium">
                                                                <a href="{{ $qrCode->link }}" target="_blank">{{ $qrCode->link }}</a>
                                                            </p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-muted">Criado por</label>
                                                            <p class="fw-medium">{{ $qrCode->creator->name ?? 'Sistema' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-center">
                                                            <label class="form-label text-muted">QR Code</label>
                                                            <div class="qr-code-display p-3 bg-light rounded">
                                                                {!! QrCode::size(150)->generate($qrCode->link) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($qrCode->establishments->count() > 0)
                                                    <hr>
                                                    <h6>Estabelecimentos Vinculados</h6>
                                                    <div class="row">
                                                        @foreach($qrCode->establishments as $establishment)
                                                            <div class="col-md-6 mb-2">
                                                                <div class="border rounded p-2">
                                                                    <strong>{{ $establishment->nome }}</strong><br>
                                                                    <small class="text-muted">{{ $establishment->cidade }}</small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-qrcode fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Nenhum QR Code encontrado</h5>
                                    <p class="text-muted">Clique em "Novo QR Code" para criar o primeiro QR Code.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($qrCodes->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $qrCodes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Criação de QR Code -->
<div class="modal fade" id="createQrCodeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.qr-codes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Link <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="link" name="link" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_establishments" class="form-label">Máximo de Estabelecimentos</label>
                        <input type="number" class="form-control" id="max_establishments" name="max_establishments" value="0" min="0">
                        <div class="form-text">0 = sem limite</div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            QR Code ativo
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar QR Code</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleStatus(qrCodeId) {
        if (confirm('Tem certeza que deseja alterar o status deste QR Code?')) {
            // Aqui você pode implementar a chamada AJAX para alterar o status
            // Por exemplo:
            fetch(`/admin/qr-codes/${qrCodeId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }
</script>
@endpush
