<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Concluído - SeguraEssa.app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .success-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #1a5276;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header img {
            max-width: 180px;
            margin-bottom: 15px;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .next-steps {
            margin-top: 30px;
            padding: 20px;
            background-color: #f0f7ff;
            border-radius: 8px;
            text-align: left;
            border-left: 5px solid #2e86de;
        }
        .next-steps h3 {
            color: #1a5276;
            margin-bottom: 15px;
        }
        .next-steps ul {
            padding-left: 20px;
        }
        .next-steps li {
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #2e86de;
            border-color: #2e86de;
            padding: 10px 20px;
            font-weight: 600;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #1a5276;
            border-color: #1a5276;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #777;
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: #ddd;
            z-index: 1;
        }
        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 33.33%;
        }
        .step-circle {
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            background: #ddd;
            color: #fff;
            margin: 0 auto 10px;
            font-weight: bold;
        }
        .step.completed .step-circle {
            background: #28a745;
        }
        .step-title {
            font-size: 14px;
            color: #777;
        }
        .step.completed .step-title {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="SeguraEssa.app Logo">
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