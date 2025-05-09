<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Concluído - SeguraEssa.app</title>
    <link rel="icon" href="{{ asset('assets/admin/img/favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/establishments/success.css') }}">
</head>
<body>
    <div class="success-container">
        <div class="header">
            <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="SeguraEssa.app Logo">
            <h1>Cadastro Concluído com Sucesso!</h1>
        </div>

        <div class="content">
            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Cadastro Inicial</div>
                </div>
                <div class="step completed">
                    <div class="step-circle">2</div>
                    <div class="step-title">Termos</div>
                </div>
                <div class="step completed">
                    <div class="step-circle">3</div>
                    <div class="step-title">Conclusão</div>
                </div>
            </div>

            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <h2>Parabéns, {{ $establishment->nome }}!</h2>
            <p class="lead">Seu cadastro foi concluído com sucesso. Agradecemos por se tornar um parceiro do SeguraEssa.app!</p>

            <a href="{{ route('site.index') }}" class="btn btn-primary">Voltar para a Página Inicial</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
        </div>
    </div>
</body>
</html>
