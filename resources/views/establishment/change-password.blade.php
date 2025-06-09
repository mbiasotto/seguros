@extends('establishment.layouts.app')

@section('title', 'Alterar Senha')

@push('styles')
<style>
.password-wrapper {
    position: relative;
}

.password-toggle-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
    z-index: 10;
    transition: color 0.2s;
}

.password-toggle-icon:hover {
    color: #495057;
}
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Alterar Senha</h1>
        @include('admin.components.back-button', ['route' => route('establishment.dashboard')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h2 class="h5 mb-1">Definir nova senha</h2>
                        <p class="text-muted">Defina uma nova senha para sua conta.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
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

                    @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('establishment.change-password.update') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nova Senha <span class="text-danger">*</span></label>
                                    <div class="password-wrapper">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                                        </div>
                                        <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-sm">Mínimo 8 caracteres.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha <span class="text-danger">*</span></label>
                                    <div class="password-wrapper">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                                        </div>
                                        <i class="fas fa-eye password-toggle-icon" id="togglePasswordConfirm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('establishment.dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="fas fa-save me-2"></i> Alterar Senha
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
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').click(function() {
        const password = $('#password');
        const type = password.attr('type') === 'password' ? 'text' : 'password';
        password.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $('#togglePasswordConfirm').click(function() {
        const password = $('#password_confirmation');
        const type = password.attr('type') === 'password' ? 'text' : 'password';
        password.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
});
</script>
@endpush
