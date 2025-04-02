<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao SeguraEssa.app</title>
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
            background: linear-gradient(135deg, #1e5799 0%, #2989d8 50%, #207cca 100%);
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
            color: #1e5799;
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
            background-color: #f0f7ff;
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            border-left: 5px solid #3498db;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .credentials p {
            margin: 10px 0;
        }

        /* Passos */
        .steps {
            margin: 35px 0;
        }

        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            background-color: #f9f9f9;
            padding: 18px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .step:hover {
            background-color: #f0f7ff;
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        .step-number {
            min-width: 32px;
            height: 32px;
            background-color: #2989d8;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border-radius: 6px;
            margin-right: 18px;
            flex-shrink: 0;
            text-align: center;
            line-height: 32px;
        }

        .step-content {
            flex-grow: 1;
            font-size: 16px;
            padding-top: 5px;
        }

        /* Botão */
        .button-container {
            text-align: center;
            margin: 35px 0 15px;
        }

        .button {
            display: inline-block;
            background: linear-gradient(to right, #1e5799 0%, #2989d8 100%);
            color: white !important;
            text-decoration: none;
            padding: 16px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(46, 134, 222, 0.35);
            mso-padding-alt: 16px 30px;
        }

        .button:hover {
            background: linear-gradient(to right, #166ab8 0%, #1a7bc5 100%);
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

            .step {
                padding: 15px;
            }

            .step-number {
                width: 32px;
                height: 32px;
                font-size: 16px;
                margin-right: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <img src="{{ asset('img/logo.png') }}" alt="SeguraEssa.app Logo">
                <h1>Bem-vindo ao SeguraEssa.app!</h1>
                <p>Complete seu cadastro de estabelecimento parceiro</p>
            </div>

            <div class="content">
                <h2>Olá, {{ $establishment->nome }}!</h2>

                <p>É com grande satisfação que damos as boas-vindas ao seu estabelecimento como novo parceiro do SeguraEssa.app! Estamos muito felizes em tê-lo conosco.</p>

                <p>Para completar seu cadastro, precisamos que você realize algumas etapas importantes:</p>

                <div class="steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">Acesse o link seguro abaixo para completar seu cadastro</div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">Faça o upload do documento solicitado (CNPJ ou documento de identificação)</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">Leia e aceite os termos do contrato de parceria</div>
                    </div>
                </div>

                <p>O link abaixo é exclusivo para seu estabelecimento e expirará em 7 dias. Por favor, complete o processo o quanto antes:</p>

                <div class="credentials">
                    <p><strong>🔗 Link de acesso seguro:</strong> <a href="{{ route('establishment.onboarding', ['token' => $onboarding->token]) }}" style="color: #2989d8; text-decoration: underline;">Completar Cadastro</a></p>
                </div>

                <p>Se você tiver qualquer dúvida ou precisar de suporte, nossa equipe estará sempre disponível para ajudar. Basta responder a este e-mail ou entrar em contato através do nosso canal de suporte.</p>

                <div class="button-container">
                    <a href="{{ route('establishment.onboarding', ['token' => $onboarding->token]) }}" class="button">Completar Meu Cadastro</a>
                </div>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
                <p>Este e-mail foi enviado para {{ $establishment->email ?? 'você' }}</p>
                <p><small>Se você recebeu este e-mail por engano, por favor desconsidere-o.</small></p>
            </div>
        </div>
    </div>
</body>
</html>
