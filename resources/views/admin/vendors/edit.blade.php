@extends('admin.layouts.app')

@section('title', 'Editar Vendedor')


@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Editar Vendedor</h1>
        @include('admin.components.back-button', ['route' => route('admin.vendors.index')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

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
                            <!-- Informações Pessoais -->
                            <div class="col-12">
                                <h5 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações Pessoais</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('nome') is-invalid @enderror"
                                           id="nome" name="nome" value="{{ old('nome', $vendor->nome) }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $vendor->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nova Senha (opcional)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               id="password" name="password">
                                        <button type="button" class="btn btn-secondary" id="generatePassword">
                                            <i class="fas fa-key me-1"></i> Gerar
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="text" class="form-control form-control-lg"
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <!-- Informações de Contato -->
                            <div class="col-12">
                                <h5 class="font-semibold text-lg border-bottom pb-2 mb-4">Informações de Contato</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('telefone') is-invalid @enderror"
                                           id="telefone" name="telefone" value="{{ old('telefone', $vendor->telefone) }}"
                                           placeholder="(00) 00000-0000" required>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg @error('cidade') is-invalid @enderror"
                                           id="cidade" name="cidade" value="{{ old('cidade', $vendor->cidade) }}" required>
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('estado') is-invalid @enderror"
                                           id="estado" name="estado" required>
                                        <option value="">Selecione o estado</option>
                                        @foreach(\App\Models\Estado::orderBy('nome')->get() as $estado)
                                            <option value="{{ $estado->sigla }}" {{ old('estado', $vendor->estado) == $estado->sigla ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                        @endforeach
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $vendor->ativo) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">Ativo</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-times me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-save me-2"></i> Salvar
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

@push('scripts')
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/utils/form-utils.js') }}"></script>
<script>
    $(document).ready(function() {
        // Gerador de senha
        $('#generatePassword').click(function() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+';
            let password = '';

            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            $('#password').val(password);
            $('#password_confirmation').val(password);
        });
    });
</script>
@endpush
