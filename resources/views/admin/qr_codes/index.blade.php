@extends('admin.layouts.app')

@section('title', 'QR Codes')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">QR Codes</h1>
    <a href="{{ route('admin.qr-codes.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo QR Code</span>
    </a>
</div>

@if($qrCodes->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <i class="fas fa-qrcode text-muted fa-3x mb-3"></i>
            <h4 class="mt-3">Nenhum QR Code cadastrado</h4>
            <p class="text-muted mb-4">Clique no botão "Novo QR Code" para começar.</p>
            <a href="{{ route('admin.qr-codes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo QR Code
            </a>
        </div>
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($qrCodes as $qrCode)
                        <tr>
                            <td class="fw-medium">{{ $qrCode->title ?: 'Sem título' }}</td>
                            <td>{{ Str::limit($qrCode->link, 50) }}</td>
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