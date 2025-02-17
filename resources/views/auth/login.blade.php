<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
    </style>
</head>
<body>
    <main class="form-signin text-center">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Painel Administrativo</h1>

            @error('email')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" required autofocus>
                <label for="email">E-mail</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                <label for="password">Senha</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
