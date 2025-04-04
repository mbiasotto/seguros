@extends('admin.layouts.app')

@section('title', 'Detalhes do Documento')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Detalhes do Documento</h1>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                        <i class="fas fa-arrow-left me-2"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">Informações do Estabelecimento</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">{{ $onboarding->establishment->nome }}</h6>
                    <p class="mb-1"><strong>CNPJ:</strong> {{ $onboarding->establishment->cnpj }}</p>
                    <p class="mb-1"><strong>Endereço:</strong> {{ $onboarding->establishment->endereco }}</p>
                    <p class="mb-1"><strong>Cidade/UF:</strong> {{ $onboarding->establishment->cidade }}/{{ $onboarding->establishment->estado }}</p>
                    <p class="mb-1"><strong>Telefone:</strong> {{ $onboarding->establishment->telefone }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $onboarding->establishment->email }}</p>
                    <p class="mb-1"><strong>Vendedor:</strong> {{ $onboarding->establishment->vendor->name }}</p>
                    <p class="mb-1"><strong>Data de Cadastro:</strong> {{ $onboarding->establishment->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">Documento</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="mb-1"><strong>Enviado em:</strong> {{ $onboarding->completed_at->format('d/m/Y H:i') }}</p>

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

                            @if($onboarding->document_approval_notes)
                                <p class="mb-1"><strong>Observações:</strong> {{ $onboarding->document_approval_notes }}</p>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('admin.establishments.documents.view', $onboarding) }}" class="btn btn-primary d-flex align-items-center justify-content-center" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i> Visualizar Documento
                            </a>
                        </div>
                    </div>

                    @if(!$onboarding->document_approved_at)
                        <div class="mt-4 pt-4 border-top">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
