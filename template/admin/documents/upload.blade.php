@extends('admin.layouts.app')

@section('title', 'Upload de Documento - ' . $establishment->nome)

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Upload de Documento</h1>
                <a href="{{ route('admin.establishments.index') }}" class="btn btn-outline-secondary font-medium">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Documento para: <strong>{{ $establishment->nome }}</strong></h5>
                        <span class="badge bg-primary">ID: {{ $establishment->id }}</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.establishments.documents.upload.store', $establishment->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label for="document" class="form-label">Selecione o Documento <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control form-control-lg @error('document') is-invalid @enderror" id="document" name="document" required accept=".pdf,.jpg,.jpeg,.png">
                                    @error('document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="form-text mt-2">Formatos permitidos: PDF, JPG, JPEG, PNG. Tamanho máximo: 5MB.</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($onboarding && $onboarding->document_path)
                            <div class="alert alert-warning d-flex align-items-center mb-4">
                                <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                                <div>
                                    <strong>Atenção:</strong> Enviar um novo arquivo substituirá o documento atual e marcará como pendente de aprovação.
                                </div>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('admin.establishments.documents.view', $onboarding) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-file me-1"></i> Visualizar documento atual
                                </a>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.establishments.index') }}" class="btn btn-outline-secondary me-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
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
