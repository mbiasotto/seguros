<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Concluído - SeguraEssa.app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/establishments/success.css') }}">
</head>
<body>
    <div class="success-container">
        <div class="header">
            <img src="{{ asset('img/site/logo.png') }}" alt="SeguraEssa.app Logo">
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
                    <div class="step-title">Documentação</div>
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

            <div class="next-steps">
                <h3><i class="fas fa-clipboard-list me-2"></i> Próximos Passos</h3>
                <ul>
                    <li>Nossa equipe irá analisar a documentação enviada em até 48 horas úteis.</li>
                    <li>Você receberá um e-mail de confirmação quando a análise for concluída.</li>
                    <li>Após a aprovação, seu estabelecimento estará pronto para começar a utilizar nossos serviços.</li>
                    <li>Em caso de dúvidas, entre em contato com nosso suporte pelo e-mail: <strong>suporte@seguraessa.app</strong></li>
                </ul>
            </div>

            <a href="{{ route('site.index') }}" class="btn btn-primary">Voltar para a Página Inicial</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
        </div>
    </div>
</body>
</html>
