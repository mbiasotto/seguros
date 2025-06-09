<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Seus dados de acesso - SeguraEssa.app</title>
    <style type="text/css">
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
            background: linear-gradient(135deg, #1D40AE 0%, #2A48A7 50%, #1735A8 100%);
            color: white;
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
            color: #1D40AE;
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
            background-color: rgba(29, 64, 174, 0.1);
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            border-left: 5px solid #1D40AE;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .credentials h3 {
            color: #1D40AE;
            margin: 0 0 15px;
            font-size: 18px;
            font-weight: 600;
        }

        .credentials p {
            margin: 10px 0;
            font-size: 16px;
        }

        .credential-item {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border: 1px solid #e0e6ed;
        }

        .credential-label {
            font-weight: 600;
            color: #1D40AE;
            margin-bottom: 5px;
        }

        .credential-value {
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            word-break: break-all;
        }

        /* Botão */
        .button-container {
            text-align: center;
            margin: 35px 0 15px;
        }

        .button {
            display: inline-block;
            background-color: #1D40AE;
            background: linear-gradient(to right, #1D40AE 0%, #2A48A7 100%);
            color: white !important;
            text-decoration: none;
            padding: 16px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(29, 64, 174, 0.35);
            mso-padding-alt: 16px 30px;
        }

        /* Avisos importantes */
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .warning h4 {
            margin: 0 0 10px;
            color: #856404;
            font-weight: 600;
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
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }

            .content, .header {
                padding: 25px 20px;
            }

            h1 {
                font-size: 24px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Cabeçalho -->
            <div class="header">
                <h1>Bem-vindo!</h1>
                <p>Seus dados de acesso - SeguraEssa.app</p>
            </div>

            <!-- Conteúdo -->
            <div class="content">
                <h2>Olá, {{ $establishment->nome }}!</h2>

                <p>Parabéns! Você concluiu com sucesso o processo de cadastro no SeguraEssa.app.</p>

                <p>Agora você pode acessar sua área restrita e acompanhar as estatísticas dos seus QR Codes vinculados.</p>

                <div class="credentials">
                    <h3>🔐 Seus dados de acesso:</h3>

                    <div class="credential-item">
                        <div class="credential-label">E-mail:</div>
                        <div class="credential-value">{{ $establishment->email }}</div>
                    </div>

                    <div class="credential-item">
                        <div class="credential-label">Senha temporária:</div>
                        <div class="credential-value">{{ $temporaryPassword }}</div>
                    </div>
                </div>

                <div class="warning">
                    <h4>⚠️ Importante:</h4>
                    <p><strong>Esta é uma senha temporária.</strong> Após o primeiro acesso, recomendamos que você altere sua senha para uma de sua preferência através do menu "Meu Perfil".</p>
                </div>

                <div class="button-container">
                    <a href="{{ route('establishment.login') }}" class="button">
                        Acessar Minha Área
                    </a>
                </div>

                <p>Na sua área restrita você poderá:</p>
                <ul>
                    <li>Visualizar estatísticas de acesso aos seus QR Codes</li>
                    <li>Acompanhar gráficos de acessos mensais</li>
                    <li>Ver logs de acessos recentes</li>
                    <li>Gerenciar suas informações de perfil</li>
                    <li>Alterar sua senha</li>
                </ul>

                <p>Se você tiver alguma dúvida ou precisar de suporte, não hesite em entrar em contato conosco.</p>

                <p>Atenciosamente,<br>
                Equipe SeguraEssa.app</p>
            </div>

            <!-- Rodapé -->
            <div class="footer">
                <p>&copy; {{ date('Y') }} SeguraEssa.app. Todos os direitos reservados.</p>
                <p>Este é um e-mail automático, não responda.</p>
            </div>
        </div>
    </div>
</body>
</html>
