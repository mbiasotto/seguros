@extends('admin.layouts.app')

@section('title', 'Visualizar QR Code')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/seguraessa.css') }}">
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3 mb-0">Visualizar QR Code</h1>
        <p class="text-muted">{{ $qrCode->title ?: 'QR Code sem título' }}</p>
    </div>
    <a href="{{ route('admin.qr-codes.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Informações</h5>

                <div class="qr-code-info">
                    <label class="form-label fw-bold">Título</label>
                    <p>{{ $qrCode->title ?: 'Sem título' }}</p>
                </div>

                <div class="qr-code-info">
                    <label class="form-label fw-bold">Link/Mensagem</label>
                    <p><a href="{{ $qrCode->link }}" target="_blank">{{ $qrCode->link }}</a></p>
                </div>

                <div class="qr-code-info">
                    <label class="form-label fw-bold">URL do QR Code</label>
                    <p><a href="{{ $qrCode->qr_code_url }}" target="_blank">{{ $qrCode->qr_code_url }}</a></p>
                </div>

                @if($qrCode->description)
                <div class="qr-code-info">
                    <label class="form-label fw-bold">Descrição</label>
                    <p>{{ $qrCode->description }}</p>
                </div>
                @endif

                <div class="qr-code-info">
                    <label class="form-label fw-bold">Status</label>
                    @if($qrCode->active)
                        <span class="badge bg-success">Ativo</span>
                    @else
                        <span class="badge bg-danger">Inativo</span>
                    @endif
                </div>

                <div class="qr-code-actions mt-4">
                    <a href="{{ route('admin.qr-codes.edit', $qrCode) }}" class="btn btn-primary">
                        <i class="fas fa-pencil-alt me-2"></i>Editar
                    </a>
                    <form action="{{ route('admin.qr-codes.destroy', $qrCode) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este QR Code?')">
                            <i class="fas fa-trash-alt me-2"></i>Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <h5 class="card-title mb-4">QR Code</h5>

                <div class="qr-code-container mb-4">
                    <img src="data:image/png;base64,{{ base64_encode($qrCodeImage) }}" alt="QR Code" class="img-fluid">
                </div>

                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-success" onclick="window.print(); return false;">
                        <i class="fas fa-print me-2"></i>Imprimir QR Code
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .qr-code-container, .qr-code-container * {
            visibility: visible;
        }
        .qr-code-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
@endpush
