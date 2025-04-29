@extends('vendor.layouts.app')

@section('title', 'Upload de Documento - ' . $establishment->nome)

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold">Upload de Documento</h2>
                <a href="{{ route('vendor.establishments.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para meus estabelecimentos
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                 <div class="card-header bg-light">
                    <h5 class="mb-0">Enviar documento para: <strong>{{ $establishment->nome }}</strong></h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('vendor.establishments.documents.upload.store', $establishment->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                         <div class="mb-4">
                            <label for="document" class="form-label fs-5">Selecione o Documento</label>
                            <input type="file" class="form-control form-control-lg @error('document') is-invalid @enderror" id="document" name="document" required accept=".pdf,.jpg,.jpeg,.png">
                            @error('document')
                                <div class="invalid-feedback mt-1">{{ $message }}</div>
                            @else
                                <div class="form-text mt-2">Formatos permitidos: PDF, JPG, JPEG, PNG. Tamanho máximo: 5MB.</div>
                            @enderror
                        </div>

                        @if($onboarding && $onboarding->document_path)
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                Seu estabelecimento já possui um documento enviado (<a href="{{ route('vendor.establishments.documents.view', $onboarding) }}" target="_blank">visualizar</a>).
                                @if($onboarding->document_approved)
                                    <span class="badge bg-success ms-1">Aprovado</span>
                                @elseif($onboarding->document_approved_at)
                                    <span class="badge bg-danger ms-1">Rejeitado</span>
                                @else
                                    <span class="badge bg-warning text-dark ms-1">Pendente de Aprovação</span>
                                @endif
                                <br>Enviar um novo arquivo substituirá o atual e o colocará novamente em status pendente para análise do administrador.
                            </div>
                        </div>
                        @else
                         <div class="alert alert-warning d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                Nenhum documento foi enviado para este estabelecimento ainda. O documento será analisado pelo administrador.
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center">
                                <i class="fas fa-upload me-2"></i> Enviar Documento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
