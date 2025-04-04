<!DOCTYPE html>
<!--
    Tela de Redefinição de Senha - Área do Vendedor
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
    <title>Redefinir Senha - Área do Vendedor</title>
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
            overflow-x: hidden;
            overflow-y: auto;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            height: 100vh;
            width: 100%;
        }

        .login-image-container {
            width: 50%;
            height: 100vh;
            position: relative;
            overflow: hidden;
            background: linear-gradient(rgba(29, 64, 174, 0.85), rgba(42, 72, 167, 0.95)), url('{{ asset('img/login-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-image {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .login-image-content {
            text-align: center;
            color: white;
            padding: 2rem;
            max-width: 80%;
            z-index: 2;
        }

        .login-image-content h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .login-form-container {
            width: 50%;
            height: 100vh;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: white;
            padding: 3rem;
            overflow-y: auto;
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

        .form-control:disabled, .form-control[readonly] {
            background-color: #e9ecef;
            opacity: 0.7;
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
                height: 300px;
                min-height: 300px;
                background: linear-gradient(rgba(29, 64, 174, 0.85), rgba(42, 72, 167, 0.95)), url('{{ asset('img/login-bg.jpg') }}') no-repeat center center;
                background-size: cover;
            }

            .login-form-container {
                min-height: auto;
                max-height: none;
                height: auto;
                padding: 2rem 1.5rem;
                overflow-y: visible;
            }

            .login-form-wrapper {
                padding: 0;
            }

            .login-image-content h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 576px) {
            .login-image-container {
                height: 240px;
            }

            .login-form-container {
                padding: 1.5rem 1.25rem;
            }

            .login-image-content h1 {
                font-size: 2.5rem;
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
            <div class="login-image-content">
                <h1>Área do Vendedor</h1>
            </div>
        </div>

        <div class="login-form-container">
            <div class="login-form-wrapper">
                <div class="logo">
                    <h1>Segura Essa</h1>
                </div>

                <div class="login-header">
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

                <form method="POST" action="{{ route('vendor.password.update') }}">
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
                        <div class="mt-2">
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

                    <button type="submit" class="btn w-100" style="background-color: #1D40AE; border-color: #1D40AE; color: white; font-weight: 500; padding: 0.6rem 1.25rem; border-radius: 0.25rem; transition: all 0.2s;">
                        <i class="fas fa-save me-2"></i> Redefinir Senha
                    </button>

                    <div class="text-center text-muted small mt-4">
                        <p class="mb-0"><a href="{{ route('vendor.login') }}" class="link-primary">Voltar para tela de login</a></p>
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

        // Validação visual de requisitos de senha
        const passwordInput = document.getElementById('password');
        const requirements = [
            { regex: /.{8,}/, index: 0 }, // Mínimo 8 caracteres
            { regex: /[A-Z]/, index: 1 }, // Pelo menos uma letra maiúscula
            { regex: /[a-z]/, index: 2 }, // Pelo menos uma letra minúscula
            { regex: /[0-9]/, index: 3 }, // Pelo menos um número
            { regex: /[@$!%*#?&]/, index: 4 } // Pelo menos um caractere especial
        ];

        passwordInput.addEventListener('input', function() {
            const value = passwordInput.value;
            const requirementsList = document.querySelectorAll('.password-wrapper + div ul li');

            requirements.forEach(item => {
                const isValid = item.regex.test(value);
                const requirementItem = requirementsList[item.index];

                if (isValid) {
                    requirementItem.classList.add('text-success');
                    requirementItem.classList.remove('text-muted');
                    requirementItem.innerHTML = requirementItem.innerHTML.replace(/^[^a-zA-Z0-9@$!%*#?&]*/, '<i class="fas fa-check-circle me-1"></i>');
                } else {
                    requirementItem.classList.remove('text-success');
                    requirementItem.classList.add('text-muted');
                    requirementItem.innerHTML = requirementItem.innerHTML.replace(/^[^a-zA-Z0-9@$!%*#?&]*/, '');
                }
            });
        });
    </script>
</body>
</html>
