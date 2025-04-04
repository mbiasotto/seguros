<!DOCTYPE html>
<!--
    Tela de Redefinição de Senha - Área Administrativa
    As cores utilizadas nesta página seguem o padrão do projeto:
    - Cor primária: #1D40AE
    - Cor secundária: #2A48A7

    Importante: Ao fazer alterações nesta página, mantenha a consistência visual
    com o restante do sistema.
-->
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redefinir Senha - Área Administrativa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.main.css') }}">
    <style>
        body {
            height: 100vh;
            overflow: hidden;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            display: flex;
            height: 100vh;
        }

        .login-image {
            width: 50%;
            background: linear-gradient(rgba(29, 64, 174, 0.85), rgba(42, 72, 167, 0.95)), url('{{ asset('img/login-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 2rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-image-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .login-form {
            width: 50%;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #fff;
        }

        .form-container {
            max-width: 420px;
            margin: 0 auto;
            width: 100%;
            padding: 3rem 2rem;
        }

        .logo {
            margin-bottom: 2rem;
            text-align: center;
        }

        .logo h1 {
            color: #1D40AE;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .logo p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .login-heading {
            margin-bottom: 2rem;
            text-align: center;
        }

        .login-heading h2 {
            font-weight: 600;
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .login-heading p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #1D40AE;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(29, 64, 174, 0.1);
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: #e2e8f0;
            color: #6c757d;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1D40AE, #2A48A7);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(29, 64, 174, 0.2);
            background: linear-gradient(135deg, #2A48A7, #1D40AE);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .form-text-link {
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .form-text-link:hover {
            color: #3a5fc8;
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        @media (max-width: 991px) {
            .login-container {
                flex-direction: column;
            }

            .login-image {
                width: 100%;
                height: 200px;
            }

            .login-form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <div class="login-image-content">
                <h2 style="font-size: 2.5rem; font-weight: 700;">Área Administrativa</h2>
            </div>
        </div>

        <div class="login-form">
            <div class="form-container">
                <div class="logo">
                    <h1>Segura Essa</h1>
                    <p>Sistema de Gestão de Estabelecimentos</p>
                </div>

                <div class="login-heading">
                    <h2>Redefinir Senha</h2>
                    <p>Crie uma nova senha para sua conta</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
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
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nova Senha</label>
                        <div class="password-wrapper">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password" name="password" required>
                            </div>
                            <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirmar Senha</label>
                        <div class="password-wrapper">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" id="password-confirm" name="password_confirmation" required>
                            </div>
                            <i class="fas fa-eye password-toggle-icon" id="togglePasswordConfirm"></i>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <button type="submit" class="btn w-100" style="background-color: #1D40AE; border-color: #1D40AE; color: white; font-weight: 500; padding: 0.6rem 1.25rem; border-radius: 0.25rem; transition: all 0.2s;">
                            <i class="fas fa-save me-2"></i> Redefinir Senha
                        </button>
                    </div>

                    <div class="text-center text-muted small mt-4">
                        <p class="mb-0"><a href="{{ route('admin.login') }}" class="form-text-link">Voltar para tela de login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelectorAll('.password-toggle-icon');

        togglePassword.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.closest('.password-wrapper').querySelector('input');
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        });

        // Adiciona efeito hover ao botão de redefinir senha
        const submitButton = document.querySelector('button[type="submit"]');
        submitButton.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#2A48A7';
            this.style.borderColor = '#2A48A7';
            this.style.boxShadow = '0 4px 10px rgba(29, 64, 174, 0.15)';
        });
        submitButton.addEventListener('mouseout', function() {
            this.style.backgroundColor = '#1D40AE';
            this.style.borderColor = '#1D40AE';
            this.style.boxShadow = 'none';
        });
    </script>
</body>
</html>
