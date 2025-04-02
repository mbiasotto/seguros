<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha - SeguraEssa.app</title>
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
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            background-color: #6366F1;
            padding: 30px 40px;
            text-align: center;
        }

        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .email-body {
            padding: 40px;
        }

        .email-footer {
            background-color: #f7f9fc;
            padding: 20px 40px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }

        /* Elementos de conteúdo */
        .greeting {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #333;
        }

        .message {
            margin-bottom: 30px;
            color: #555;
            font-size: 16px;
        }

        .cta-button {
            display: inline-block;
            background-color: #6366F1;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            margin: 25px 0;
            text-align: center;
            font-size: 16px;
        }

        .help-text {
            font-size: 15px;
            color: #6c757d;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .link-fallback {
            word-break: break-all;
            color: #6366F1;
            font-size: 14px;
            margin-top: 10px;
        }

        .timeout-warning {
            font-weight: 500;
            margin-bottom: 15px;
        }

        .app-logo {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .email-header {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td align="center">
                    <div class="email-container">
                        <div class="email-header">
                            <h1>Redefinição de Senha</h1>
                        </div>
                        <div class="email-body">
                            <div class="app-logo">SeguraEssa.app</div>

                            <div class="greeting">Olá!</div>

                            <div class="message">
                                <p>Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta na Área do Vendedor do SeguraEssa.app.</p>
                            </div>

                            <div style="text-align: center;">
                                <a href="{{ $resetUrl }}" class="cta-button">Redefinir Senha</a>
                            </div>

                            <div class="message">
                                <p class="timeout-warning">Este link de redefinição de senha expirará em 60 minutos.</p>
                                <p>Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.</p>
                            </div>

                            <div class="help-text">
                                <p>Se você estiver tendo problemas para clicar no botão "Redefinir Senha", copie e cole o URL abaixo em seu navegador:</p>
                                <div class="link-fallback">{{ $resetUrl }}</div>
                            </div>

                            <div style="margin-top: 30px;">
                                <p>Atenciosamente,<br>SeguraEssa.app</p>
                            </div>
                        </div>
                        <div class="email-footer">
                            <p>&copy; {{ date('Y') }} SeguraEssa.app. Todos os direitos reservados.</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
