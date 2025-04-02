@extends('vendor.layouts.app')

@section('title', 'Detalhes do Estabelecimento')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold">Detalhes do Estabelecimento</h2>
                <div>
                    <a href="{{ route('vendor.establishments.edit', $establishment) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Editar
                    </a>
                    <a href="{{ route('vendor.establishments.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Informações do Estabelecimento</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Nome</h6>
                    <p class="mb-0 fw-bold">{{ $establishment->nome }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Status</h6>
                    <p class="mb-0">
                        @if($establishment->ativo)
                            <span class="badge bg-success">Ativo</span>
                        @else
                            <span class="badge bg-danger">Inativo</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Endereço</h6>
                    <p class="mb-0">{{ $establishment->endereco }}{{ $establishment->numero ? ', ' . $establishment->numero : '' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Cidade/Estado</h6>
                    <p class="mb-0">{{ $establishment->cidade }}/{{ $establishment->estado }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">CEP</h6>
                    <p class="mb-0">{{ $establishment->cep }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Telefone</h6>
                    <p class="mb-0">{{ $establishment->telefone }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">E-mail</h6>
                    <p class="mb-0">{{ $establishment->email }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Data de Cadastro</h6>
                    <p class="mb-0">{{ $establishment->created_at->format('d/m/Y H:i') }}</p>
                </div>
                @if($establishment->descricao)
                <div class="col-12 mb-3">
                    <h6 class="text-muted mb-1">Descrição</h6>
                    <p class="mb-0">{{ $establishment->descricao }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
