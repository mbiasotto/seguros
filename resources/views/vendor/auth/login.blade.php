<!DOCTYPE html>
<!--
    Tela de Login - Área do Vendedor
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
    <title>Login - Área do Vendedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor.main.css') }}">
    <style>
        :root {
            --primary: #1D40AE;
            --primary-dark: #2A48A7;
            --admin-dark: #212529;
            --admin-gradient-start: #1D40AE;
            --admin-gradient-end: #2A48A7;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --info: #17a2b8;
            --warning: #ffc107;
            --light: #f8f9fa;
            --dark: #343a40;
            --text-color: #374151;
            --text-muted: #6c757d;
            --bg-light: #f8fafc;
            --border-color: #e2e8f0;
            --btn-primary-bg: linear-gradient(135deg, var(--primary), var(--primary-dark));
            --btn-primary-hover-bg: linear-gradient(135deg, var(--primary-dark), #2A48A7);
            --btn-shadow: 0 4px 12px rgba(29, 64, 174, 0.25);
        }

        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .login-image-container {
            width: 50%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .login-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(29, 64, 174, 0.85), rgba(42, 72, 167, 0.95)), url('{{ asset('img/login-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-image-content {
            text-align: center;
            color: white;
            padding: 2rem;
            max-width: 90%;
            z-index: 2;
        }

        .login-image-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .login-form-container {
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: white;
            padding: 3rem;
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo h1 {
            color: var(--primary);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .logo p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h2 {
            font-weight: 600;
            font-size: 1.75rem;
            color: var(--text-color);
            margin-bottom: 0.75rem;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .form-control {
            padding: 0.9rem 1rem;
            font-size: 1rem;
            height: auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--bg-light);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(29, 64, 174, 0.1);
        }

        .input-group-text {
            background-color: var(--bg-light);
            border-color: var(--border-color);
            color: var(--text-muted);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-muted);
            z-index: 10;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.25rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 4px 10px rgba(29, 64, 174, 0.15);
        }

        .link-primary {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .link-primary:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border: none;
        }

        @media (max-width: 991.98px) {
            .login-container {
                flex-direction: column;
            }

            .login-image-container,
            .login-form-container {
                width: 100%;
            }

            .login-image-container {
                height: 35vh;
            }

            .login-form-container {
                height: 65vh;
                padding: 2rem 1.5rem;
                overflow-y: auto;
            }

            .login-form-wrapper {
                padding: 0;
            }

            .login-image-content h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .login-image-container {
                height: 25vh;
            }

            .login-form-container {
                height: 75vh;
                padding: 1.5rem 1.25rem;
            }

            .login-image-content h1 {
                font-size: 2rem;
            }

            .logo h1 {
                font-size: 1.75rem;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image-container">
            <div class="login-image">
                <div class="login-image-content">
                    <h1>Área do Vendedor</h1>
                </div>
            </div>
        </div>

        <div class="login-form-container">
            <div class="login-form-wrapper">
                <div class="logo">
                    <h1 style="color: var(--primary);">Segura Essa</h1>
                </div>

                <div class="login-header">
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

                <form method="POST" action="{{ route('vendor.login.submit') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="seu-email@exemplo.com" required autofocus>
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
                        <a href="{{ route('vendor.password.request') }}" class="link-primary" style="color: var(--primary);">Esqueci minha senha</a>
                    </div>

                    <button type="submit" class="btn w-100" style="background-color: #1D40AE; border-color: #1D40AE; color: white; font-weight: 500; padding: 0.6rem 1.25rem; border-radius: 0.25rem; transition: all 0.2s;">
                        <i class="fas fa-sign-in-alt me-2"></i> Entrar
                    </button>

                    <div class="text-center text-muted">
                        <p>Use o e-mail e senha fornecidos pelo administrador<br>para acessar o sistema.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        // Adiciona efeito hover ao botão de login
        const loginButton = document.querySelector('button[type="submit"]');
        loginButton.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#2A48A7';
            this.style.borderColor = '#2A48A7';
            this.style.boxShadow = '0 4px 10px rgba(29, 64, 174, 0.15)';
        });
        loginButton.addEventListener('mouseout', function() {
            this.style.backgroundColor = '#1D40AE';
            this.style.borderColor = '#1D40AE';
            this.style.boxShadow = 'none';
        });
    </script>
</body>
</html>
