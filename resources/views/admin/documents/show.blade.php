@extends('admin.layouts.app')

@section('title', 'Detalhes do Documento')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<style>
    .document-preview {
        max-height: 600px;
        overflow: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
    .document-preview img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    .document-preview iframe {
        width: 100%;
        height: 600px;
        border: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Detalhes do Documento</h1>
        @include('admin.components.back-button', ['route' => route('admin.establishments.documents.pending')])
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">Informações do Estabelecimento</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">{{ $onboarding->establishment->nome }}</h6>
                    <p class="mb-1"><strong>CNPJ:</strong> {{ $onboarding->establishment->cnpj ?: 'Não informado' }}</p>
                    <p class="mb-1"><strong>Endereço:</strong> {{ $onboarding->establishment->endereco }}</p>
                    <p class="mb-1"><strong>Cidade/UF:</strong> {{ $onboarding->establishment->cidade }}/{{ $onboarding->establishment->estado }}</p>
                    <p class="mb-1"><strong>Telefone:</strong> {{ $onboarding->establishment->telefone }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $onboarding->establishment->email }}</p>
                    <p class="mb-1"><strong>Vendedor:</strong> {{ $onboarding->establishment->vendor->name ?? 'Não informado' }}</p>
                    <p class="mb-1"><strong>Data de Cadastro:</strong> {{ $onboarding->establishment->created_at->format('d/m/Y H:i') }}</p>

                    <hr>

                    <div class="mb-2">
                        <strong>Status do Documento:</strong>
                        @if($onboarding->document_approved && $onboarding->document_approved_at)
                            <span class="badge bg-success p-2 ms-2">Aprovado</span>
                        @elseif(!$onboarding->document_approved && $onboarding->document_approved_at)
                            <span class="badge bg-danger p-2 ms-2">Rejeitado</span>
                        @else
                            <span class="badge bg-warning text-dark p-2 ms-2">Pendente</span>
                        @endif
                    </div>

                    <p class="mb-1"><strong>Enviado em:</strong> {{ $onboarding->completed_at ? $onboarding->completed_at->format('d/m/Y H:i') : 'N/A' }}</p>

                    @if($onboarding->document_approved_at)
                        <p class="mb-1">
                            <strong>{{ $onboarding->document_approved ? 'Aprovado' : 'Rejeitado' }} em:</strong>
                            {{ $onboarding->document_approved_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="mb-1">
                            <strong>{{ $onboarding->document_approved ? 'Aprovado' : 'Rejeitado' }} por:</strong>
                            {{ $onboarding->approvedByUser->name }}
                        </p>
                    @endif

                    @if($onboarding->approval_notes)
                        <p class="mb-1"><strong>Observações:</strong> {{ $onboarding->approval_notes }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Documento</h5>
                    <a href="{{ route('admin.establishments.documents.view', $onboarding) }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i> Abrir em Nova Aba
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="document-preview">
                        @php
                            $extension = pathinfo($onboarding->document_path, PATHINFO_EXTENSION);
                            $isPdf = strtolower($extension) === 'pdf';
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                        @endphp

                        @if($isPdf)
                            <iframe src="{{ route('admin.establishments.documents.view', $onboarding) }}"></iframe>
                        @elseif($isImage)
                            <img src="{{ route('admin.establishments.documents.view', $onboarding) }}" alt="Documento">
                        @else
                            <div class="p-5 text-center">
                                <i class="fas fa-file-alt fa-4x mb-3 text-muted"></i>
                                <p>Visualização não disponível. <a href="{{ route('admin.establishments.documents.view', $onboarding) }}" target="_blank">Clique aqui para baixar o documento</a>.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$onboarding->document_approved_at)
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0">Ações</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('admin.establishments.documents.approve', $onboarding) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="approve-notes" class="form-label">Observações (opcional)</label>
                                        <textarea class="form-control" id="approve-notes" name="notes" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-check me-2"></i> Aprovar Documento
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('admin.establishments.documents.reject', $onboarding) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="reject-notes" class="form-label">Motivo da Rejeição <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="reject-notes" name="notes" rows="3" required></textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-times me-2"></i> Rejeitar Documento
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
