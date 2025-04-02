<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redefinir Senha - Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .password-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            margin: auto;
        }
        .password-wrapper {
            position: relative;
        }
        .password-toggle-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <main class="password-form">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Redefinir Senha</h3>

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

                <form method="POST" action="{{ route('admin.password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus readonly>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nova Senha</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                        </div>
                        <div class="form-text mt-2">
                            <small>
                                <i class="fas fa-info-circle text-primary me-1"></i> A senha deve conter:
                                <ul class="mt-1 ps-3">
                                    <li>No mínimo 8 caracteres</li>
                                    <li>Pelo menos uma letra maiúscula</li>
                                    <li>Pelo menos uma letra minúscula</li>
                                    <li>Pelo menos um número</li>
                                    <li>Pelo menos um caractere especial (ex: @, #, $, %)</li>
                                </ul>
                            </small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            <i class="fas fa-eye password-toggle-icon" id="togglePasswordConfirmation"></i>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-2"></i> Redefinir Senha
                        </button>
                        <a href="{{ route('admin.login') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Voltar para Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('fa-eye-slash');
        });

        togglePasswordConfirmation.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
