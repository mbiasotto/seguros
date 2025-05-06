<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Área do Vendedor</title>
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
                <h1>Área do Vendedor</h1>
            </div>
        </div>

        <div class="auth-form-container">
            <div class="auth-form-wrapper">
                <div class="auth-logo">
                    <img src="{{ asset('assets/admin/img/logo.png') }}" alt="Logo" class="img-fluid logo-img">
                </div>

                <div class="auth-header">
                    <h2>Área do Vendedor</h2>
                    <p>Acesse sua conta para continuar</p>
                </div>

                @if(session('message'))
                    <div class="alert alert-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <span>{{ session('message') }}</span>
                        </div>
                    </div>
                @endif

                @php
                    use Illuminate\Support\Facades\Cookie;
                    $cookieEmail = Cookie::get('vendor_remembered_email');
                @endphp

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

                <form method="POST" action="{{ route('vendor.login.submit') }}" class="auth-form">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email', $rememberedEmail ?? $cookieEmail ?? '') }}" placeholder="seu-email@exemplo.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <div class="password-wrapper">
                            <div class="input-group">
                                <span class="input-group-text border-end-0">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="••••••••" required>
                            </div>
                            <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="mb-4 text-end">
                        <a href="{{ route('vendor.password.request') }}" class="auth-link">Esqueci minha senha</a>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" {{ old('remember') || $cookieEmail ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Lembrar-me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth">
                        <i class="fas fa-sign-in-alt me-2"></i> Entrar
                    </button>

                    <div class="text-center text-muted small mt-4">
                        <p>Use o e-mail e senha fornecidos pelo administrador<br>para acessar o sistema.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/utils/auth-utils.js') }}"></script>
</body>
</html>
