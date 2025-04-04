@extends('vendor.layouts.app')

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
                    <a href="{{ route('vendor.establishments.documents') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                        <i class="fas fa-arrow-left me-2"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0">Informações do Documento</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Estabelecimento</h6>
                    <p class="mb-0 fw-bold">{{ $onboarding->establishment->nome }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Status</h6>
                    <p class="mb-0">
                        @if($onboarding->document_approved)
                            <span class="badge bg-success">Aprovado</span>
                        @elseif($onboarding->document_approved_at)
                            <span class="badge bg-danger">Rejeitado</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendente</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Data de Envio</h6>
                    <p class="mb-0">{{ $onboarding->completed_at->format('d/m/Y H:i') }}</p>
                </div>
                @if($onboarding->document_approved_at)
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Data de {{ $onboarding->document_approved ? 'Aprovação' : 'Rejeição' }}</h6>
                    <p class="mb-0">{{ $onboarding->document_approved_at->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                @if($onboarding->approvedByUser)
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">{{ $onboarding->document_approved ? 'Aprovado' : 'Rejeitado' }} por</h6>
                    <p class="mb-0">{{ $onboarding->approvedByUser->name }}</p>
                </div>
                @endif
                @if($onboarding->document_rejection_reason)
                <div class="col-12 mb-3">
                    <h6 class="text-muted mb-1">Motivo da Rejeição</h6>
                    <p class="mb-0">{{ $onboarding->document_rejection_reason }}</p>
                </div>
                @endif
            </div>

            <div class="mt-4">
                <h6 class="fw-bold mb-3">Documento Enviado</h6>
                <div class="d-flex">
                    <a href="{{ route('vendor.establishments.documents.view', $onboarding) }}" class="btn btn-primary d-flex align-items-center justify-content-center" target="_blank">
                        <i class="fas fa-file-pdf me-2"></i> Visualizar Documento
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
