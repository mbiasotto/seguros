<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redefinir Senha - Área do Fornecedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/components/auth.css') }}">
    <link rel="icon" href="{{ asset('assets/admin/img/favicon.png') }}" type="image/png">
</head>
<body>
    <div class="auth-container">
        <div class="auth-image-container">
            <div class="auth-image-content">
                <h1>Área do Fornecedor</h1>
            </div>
        </div>

        <div class="auth-form-container">
            <div class="auth-form-wrapper">
                <div class="auth-logo">
                    <img src="{{ asset('assets/admin/img/logo.png') }}" alt="Logo" class="img-fluid logo-img">
                </div>

                <div class="auth-header">
                    <h2>Redefinir Senha</h2>
                    <p>Crie uma nova senha para sua conta</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
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

                <form method="POST" action="{{ route('vendor.password.update') }}" class="auth-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ $email ?? old('email') }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nova Senha</label>
                        <div class="password-wrapper">
                            <div class="input-group">
                                <span class="input-group-text border-end-0">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="••••••••" required>
                            </div>
                            <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                        </div>
                        <div class="password-requirements mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i> A senha deve conter:
                            </small>
                            <ul class="small text-muted ps-4 mb-0 mt-1">
                                <li>Pelo menos 8 caracteres</li>
                                <li>Pelo menos uma letra maiúscula</li>
                                <li>Pelo menos uma letra minúscula</li>
                                <li>Pelo menos um número</li>
                                <li>Pelo menos um caractere especial (@$!%*#?&)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirmar Senha</label>
                        <div class="password-wrapper">
                            <div class="input-group">
                                <span class="input-group-text border-end-0">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password-confirm" name="password_confirmation" placeholder="••••••••" required>
                            </div>
                            <i class="fas fa-eye password-toggle-icon" id="togglePasswordConfirm"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth">
                        <i class="fas fa-save me-2"></i> Redefinir Senha
                    </button>

                    <div class="text-center text-muted small mt-4">
                        <p class="mb-0"><a href="{{ route('vendor.login') }}" class="auth-link">Voltar para tela de login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/utils/password-utils.js') }}"></script>
</body>
</html>
