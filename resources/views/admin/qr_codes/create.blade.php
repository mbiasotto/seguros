@extends('admin.layouts.app')

@section('title', 'Novo QR Code')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0">Novo QR Code</h1>
    <p class="text-muted">Preencha os campos abaixo para criar um novo QR Code</p>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.qr-codes.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Título (opcional)</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Um título para identificar este QR Code</div>
            </div>
            
            <div class="mb-3">
                <label for="link" class="form-label">Link ou Mensagem*</label>
                <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}" required>
                @error('link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">URL completa (ex: https://exemplo.com) ou mensagem para onde o QR Code irá direcionar</div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Descrição (opcional)</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" checked>
                    <label class="form-check-label" for="active">
                        Ativo
                    </label>
                    <div class="form-text">QR Codes inativos não redirecionarão para o link</div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.qr-codes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar QR Code</button>
            </div>
        </form>
    </div>
</div>
@endsection