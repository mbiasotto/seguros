<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Painel Administrativo</title>
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
        .login-form {
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
    <main class="login-form">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Painel Administrativo</h3>

                @if(session('message'))
                    <div class="alert alert-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <span>{{ session('message') }}</span>
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

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="admin@admin.com" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" id="password" name="password" value="123456" required>
                            <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="mb-4 text-end">
                        <a href="{{ route('admin.password.request') }}" class="text-decoration-none small">Esqueci minha senha</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i> Entrar
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
