@extends('vendor.layouts.app')

@section('title', 'Meu Perfil')

@push('styles')
{{-- Remove specific CSS, rely on admin/admin.css --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/css/data-list.css') }}"> --}}
@endpush

@section('content')
<div class="container-fluid px-0"> {{-- Keep container --}}
    {{-- Use admin page header structure --}}
    <div class="page-header">
        <h1 class="page-title">Meu Perfil</h1>
        {{-- Add admin back button component, pointing to vendor dashboard --}}
        @include('admin.components.back-button', ['route' => route('vendor.dashboard')])
    </div>

    <div class="row">
        <div class="col-12">
            {{-- Use admin card structure --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger mb-4" role="alert"> {{-- Added mb-4 for spacing --}}
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

                    {{-- Success message can be handled by @include('admin.partials.alerts') in layout --}}

                    <form action="{{ route('vendor.profile.update') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Use admin section title style --}}
                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações Pessoais</h2>

                        {{-- Use admin form row structure --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                {{-- Use admin form group style (mb-3) --}}
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    {{-- Keep disabled style, use lg control --}}
                                    <input type="text" class="form-control form-control-lg" id="nome" value="{{ $vendor->nome }}" disabled readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control form-control-lg" id="email" value="{{ $vendor->email }}" disabled readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Use admin section title style --}}
                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações de Localização</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade_display" class="form-label">Cidade</label>
                                    <input type="text" class="form-control form-control-lg" id="cidade_display" value="{{ $vendor->cidade }}" disabled readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado_display" class="form-label">Estado</label>
                                    <input type="text" class="form-control form-control-lg" id="estado_display" value="{{ $vendor->estado }}" disabled readonly>
                                </div>
                            </div>
                        </div>

                         {{-- Use admin section title style --}}
                        <h2 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações de Contato</h2>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    {{-- Add phone-mask class --}}
                                    <input type="text" class="form-control form-control-lg phone-mask @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $vendor->telefone) }}" placeholder="(00) 00000-0000" required>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Placeholder for potential second column --}}
                             <div class="col-md-6"></div>
                        </div>

                        {{-- Use admin action button structure --}}
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="fas fa-save me-2"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Scripts for masks are already loaded in layout --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="{{ asset('js/form-utils.js') }}"></script> --}}
@endpush
