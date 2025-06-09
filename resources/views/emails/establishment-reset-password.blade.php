<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Redefinir Senha - SeguraEssa.app</title>
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
                <h1>Redefinir Senha</h1>
                <p>Área do Estabelecimento - SeguraEssa.app</p>
            </div>

            <!-- Conteúdo -->
            <div class="content">
                <h2>Solicitação de redefinição de senha</h2>

                <p>Olá!</p>

                <p>Você está recebendo este e-mail porque solicitou a redefinição da senha da sua conta na área do estabelecimento.</p>

                <p>Para criar uma nova senha, clique no botão abaixo:</p>

                <div class="button-container">
                    <a href="{{ $url }}" class="button">
                        Redefinir Senha
                    </a>
                </div>

                <p>Se você não conseguir clicar no botão, copie e cole o link abaixo no seu navegador:</p>
                <p style="word-break: break-all; color: #1D40AE;">{{ $url }}</p>

                <p><strong>Importante:</strong> Este link expira em 60 minutos por questões de segurança.</p>

                <p>Se você não solicitou a redefinição de senha, pode ignorar este e-mail.</p>

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
