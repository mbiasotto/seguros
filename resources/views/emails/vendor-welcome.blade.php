<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bem-vindo ao SeguraEssa.app</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
            background-color: #1a5276;
            border-radius: 8px;
            color: white;
        }
        .header img {
            max-width: 180px;
            margin-bottom: 15px;
        }
        h1 {
            color: #ffffff;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .content {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .credentials {
            background-color: #f0f7ff;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 5px solid #2e86de;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .steps {
            margin: 25px 0;
        }
        .step {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            background-color: #f9f9f9;
            padding: 12px 15px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .step:hover {
            background-color: #f0f7ff;
            transform: translateX(5px);
        }
        .step-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: #2e86de;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border-radius: 50%;
            margin-right: 15px;
            flex-shrink: 0;
            line-height: 1;
        }
        .step-content {
            flex-grow: 1;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .button {
            display: inline-block;
            background-color: #2e86de;
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            margin-top: 25px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(46, 134, 222, 0.3);
        }
        .button:hover {
            background-color: #1a5276;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(46, 134, 222, 0.4);
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('img/logo.png') }}" alt="SeguraEssa.app Logo">
        <h1>Bem-vindo ao SeguraEssa.app!</h1>
    </div>

    <div class="content">
        <p>Olá <strong>{{ $vendor->nome }}</strong>,</p>

        <p>É com grande satisfação que damos as boas-vindas a você como novo vendedor parceiro do SeguraEssa.app! Estamos muito felizes em tê-lo em nossa equipe.</p>

        <p>Abaixo estão suas informações de acesso à plataforma:</p>

        <div class="credentials">
            <p><strong>E-mail:</strong> {{ $vendor->email }}</p>
            <p><strong>Senha:</strong> {{ $plainPassword }}</p>
            <p><strong>Link de acesso:</strong> <a href="{{ route('vendor.login') }}">Acessar Painel do Vendedor</a></p>
        </div>

        <p>Para começar a utilizar nossa plataforma, siga os passos abaixo:</p>

        <div class="steps">
            <div class="step">
                <span class="step-number">1</span>
                <div class="step-content">Acesse o link fornecido acima ou vá para <a href="{{ route('vendor.login') }}">{{ route('vendor.login') }}</a></div>
            </div>
            <div class="step">
                <span class="step-number">2</span>
                <div class="step-content">Faça login com seu e-mail e senha</div>
            </div>
            <div class="step">
                <span class="step-number">3</span>
                <div class="step-content">Complete seu perfil com todas as informações necessárias</div>
            </div>
            <div class="step">
                <span class="step-number">4</span>
                <div class="step-content">Explore o painel para se familiarizar com as funcionalidades</div>
            </div>
            <div class="step">
                <span class="step-number">5</span>
                <div class="step-content">Comece a cadastrar estabelecimentos parceiros e acompanhe suas comissões</div>
            </div>
        </div>

        <p>Se você tiver qualquer dúvida ou precisar de suporte, não hesite em entrar em contato conosco respondendo a este e-mail ou através do nosso suporte.</p>

        <a href="{{ route('vendor.login') }}" class="button">Acessar Minha Conta</a>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
        <p>Este e-mail foi enviado para {{ $vendor->email }}</p>
    </div>
</body>
</html>