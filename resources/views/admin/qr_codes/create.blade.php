@extends('admin.layouts.app')

@section('title', 'Novo QR Code')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Novo QR Code</h1>
        @include('admin.components.back-button', ['route' => route('admin.qr-codes.index')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.qr-codes.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row g-4">
                            <div class="col-12">
                                <h2 class="fw-bold text-lg mb-3">Informações do QR Code</h2>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Título (opcional)</label>
                                    <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-sm">Um título para identificar este QR Code</div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link ou Mensagem <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}" required>
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-sm">URL completa (ex: https://exemplo.com) ou mensagem para onde o QR Code irá direcionar</div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descrição (opcional)</label>
                                    <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1" checked style="width: 3em; height: 1.5em;">
                                        <label class="form-check-label fs-5 ms-2" for="active">
                                            QR Code Ativo
                                        </label>
                                        <div class="form-text text-sm">QR Codes inativos não redirecionarão para o link</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.qr-codes.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-times me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-save me-2"></i> Cadastrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
