<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Senha - Área Administrativa</title>
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
                <h1>Área Administrativa</h1>
            </div>
        </div>

        <div class="auth-form-container">
            <div class="auth-form-wrapper">
                <div class="auth-logo">
                    <img src="{{ asset('assets/admin/img/logo.png') }}" alt="Logo" class="img-fluid logo-img">
                </div>

                <div class="auth-header">
                    <h2>Recuperar Senha</h2>
                    <p>Enviaremos um link para o seu email</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

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

                <form method="POST" action="{{ route('admin.password.email') }}" class="auth-form">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="seu-email@exemplo.com" required autofocus>
                        </div>
                        <div class="form-text">
                            Informe o e-mail cadastrado para receber as instruções de recuperação de senha.
                        </div>
                    </div>

                    <div class="d-grid gap-3 mb-4">
                        <button type="submit" class="btn btn-auth">
                            <i class="fas fa-paper-plane me-2"></i> Enviar Link de Recuperação
                        </button>

                        <a href="{{ route('admin.login') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Voltar para Login
                        </a>
                    </div>

                    <div class="text-center text-muted small mt-3">
                        <p>Se você não receber o email em alguns minutos,<br>verifique sua pasta de spam ou entre em contato com o suporte.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/utils/auth-utils.js') }}"></script>
</body>
</html>

