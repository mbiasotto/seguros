<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Painel Administrativo - SeguraEssa.app</title>
    <style>
        /* Reset de estilos para clientes de email */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f7f9fc;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        /* Layout principal */
        .email-wrapper {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f9fc;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        /* Cabeçalho */
        .header {
            text-align: center;
            padding: 35px 30px;
            background: linear-gradient(135deg, #1e5799 0%, #2989d8 50%, #207cca 100%); /* Blue color scheme */
            color: white;
        }

        .header img {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 10px 0 0;
            font-size: 16px;
        }

        /* Conteúdo */
        .content {
            padding: 40px 30px;
        }

        h2 {
            color: #1e5799; /* Blue color */
            font-size: 22px;
            margin: 0 0 20px;
            font-weight: 600;
        }

        p {
            margin: 0 0 20px;
            font-size: 16px;
            color: #505050;
        }

        /* Credenciais */
        .credentials {
            background-color: #f0f7ff; /* Blue color scheme */
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            border-left: 5px solid #3498db; /* Blue color */
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .credentials p {
            margin: 10px 0;
        }

        /* Botão */
        .button-container {
            text-align: center;
            margin: 35px 0 15px;
        }

        .button {
            display: inline-block;
            background: linear-gradient(to right, #1e5799 0%, #2989d8 100%); /* Blue color */
            color: white !important;
            text-decoration: none;
            padding: 16px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(46, 134, 222, 0.35); /* Blue color */
            mso-padding-alt: 16px 30px;
        }

        .button:hover {
            background: linear-gradient(to right, #166ab8 0%, #1a7bc5 100%); /* Darker blue color */
        }

        /* Rodapé */
        .footer {
            text-align: center;
            font-size: 14px;
            color: #878787;
            margin-top: 40px;
            padding: 25px 30px;
            background-color: #f9f9f9;
            border-top: 1px solid #eaeaea;
        }

        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #878787;
        }

        /* Responsividade */
        @media screen and (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }

            .header, .content, .footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .header p {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <img src="{{ asset('img/logo.png') }}" alt="SeguraEssa.app Logo">
                <h1>Bem-vindo ao Painel Administrativo</h1>
                <p>Sua central de controle SeguraEssa.app</p>
            </div>

            <div class="content">
                <h2>Olá, {{ $name }}!</h2>

                <p>É com prazer que confirmamos seu cadastro como administrador(a) na plataforma SeguraEssa.app.</p>

                <p>Abaixo estão suas credenciais de acesso ao painel administrativo. Guarde-as em local seguro:</p>

                <div class="credentials">
                    <p><strong>✉️ E-mail:</strong> {{ $email }}</p>
                    <p><strong>🔐 Senha:</strong> {{ $password }}</p>
                    <p><strong>🔗 Link de acesso:</strong> <a href="{{ url('/admin/login') }}" style="color: #2989d8; text-decoration: underline;">Acessar Painel Administrativo</a></p>
                </div>

                <p>Recomendamos fortemente que você altere sua senha no primeiro acesso por motivos de segurança.</p>

                <p>Explore as funcionalidades disponíveis para gerenciar vendedores, estabelecimentos, aprovações e muito mais.</p>

                <p>Se precisar de ajuda ou tiver alguma dúvida, não hesite em contatar o suporte.</p>

                <div class="button-container">
                    <a href="{{ url('/admin/login') }}" class="button">Acessar Painel Admin</a>
                </div>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
                <p>Este e-mail foi enviado para {{ $email }}</p>
                <p><small>Este é um e-mail automático, por favor não responda.</small></p>
            </div>
        </div>
    </div>
</body>
</html>
