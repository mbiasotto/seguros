<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termo já aceito - SeguraEssa.app</title>
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
    <link rel="stylesheet" href="{{ asset('assets/establishments/onboarding.css') }}">
    <style>
        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 2rem;
        }
        .info-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .completion-date {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="onboarding-container">
        <div class="header">
            <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="SeguraEssa.app Logo">
            <h1>Cadastro já concluído</h1>
            <p>O termo de parceria para este estabelecimento já foi aceito anteriormente.</p>
        </div>

        <div class="content">
            <div class="info-container text-center">
                <i class="fas fa-check-circle success-icon"></i>

                <h2 class="mb-4">Olá, {{ $establishment->nome }}!</h2>
                <p class="mb-4">Você já concluiu o processo de aceite do termo de parceria com o SeguraEssa.app.</p>

                @if($onboarding->contract_accepted_at)
                <div class="completion-date">
                    <p><strong>Data do aceite:</strong> {{ $onboarding->contract_accepted_at->format('d/m/Y H:i') }}</p>
                </div>
                @endif

                <div class="alert alert-success mt-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    Seu cadastro está ativo e você já pode aproveitar todos os benefícios da nossa parceria!
                </div>

                <div class="mt-5">
                    <a href="{{ route('site.index') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i> Ir para a página inicial
                    </a>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
