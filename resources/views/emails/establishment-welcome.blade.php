<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Bem-vindo ao SeguraEssa.app</title>
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
            background: linear-gradient(135deg, #1D40AE 0%, #2A48A7 50%, #1735A8 100%); /* Esquema de cores do admin */
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
            color: #1D40AE; /* Cor primária do admin */
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
            background-color: rgba(29, 64, 174, 0.1); /* Cor primária com transparência */
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            border-left: 5px solid #1D40AE; /* Cor primária do admin */
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
        }

        @media not all and (min-width: 0) {
            .step:hover {
                background-color: #f0f7ff;
                transform: translateX(5px);
                box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            }
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
            background-color: #1D40AE;
            background: linear-gradient(to right, #1D40AE 0%, #2A48A7 100%); /* Cores do admin */
            color: white !important;
            text-decoration: none;
            padding: 16px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(29, 64, 174, 0.35); /* Cor primária do admin */
            mso-padding-alt: 16px 30px;
        }

        .button:hover {
            background: linear-gradient(to right, #1735A8 0%, #1D40AE 100%); /* Tons mais escuros */
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
    <!--[if mso]>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
    <td align="center">
    <![endif]-->
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <!--[if mso]>
                <table role="presentation" width="100%">
                <tr>
                <td style="padding: 35px 30px; text-align: center; background: linear-gradient(135deg, #1e5799 0%, #2989d8 50%, #207cca 100%); color: white;">
                <![endif]-->
                <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="SeguraEssa.app Logo" width="200" height="auto" style="max-width: 200px; margin-bottom: 20px;">
                <h1>Bem-vindo ao SeguraEssa.app!</h1>
                <p>Complete seu cadastro de estabelecimento parceiro</p>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </div>

            <div class="content">
                <h2>Olá, {{ $establishment->nome }}!</h2>

                <p>É com grande satisfação que damos as boas-vindas ao seu estabelecimento como novo parceiro do SeguraEssa.app! Estamos muito felizes em tê-lo conosco.</p>

                <p>Para completar seu cadastro, precisamos que você realize algumas etapas simples:</p>

                <div class="steps">
                    <!--[if mso]>
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <![endif]-->

                    <!--[if mso]>
                    <tr>
                    <td style="padding: 18px 20px; background-color: #f9f9f9; border-radius: 10px; margin-bottom: 25px;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                    <td style="width: 32px; vertical-align: top;">
                    <![endif]-->
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">Acesse o link seguro abaixo para completar seu cadastro</div>
                    </div>
                    <!--[if mso]>
                    </td>
                    </tr>
                    </table>
                    </td>
                    </tr>
                    <![endif]-->

                    <!--[if mso]>
                    <tr>
                    <td style="padding: 18px 20px; background-color: #f9f9f9; border-radius: 10px; margin-bottom: 25px;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                    <td style="width: 32px; vertical-align: top;">
                    <![endif]-->
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">Assista ao vídeo de apresentação para conhecer melhor o SeguraEssa</div>
                    </div>
                    <!--[if mso]>
                    </td>
                    </tr>
                    </table>
                    </td>
                    </tr>
                    <![endif]-->

                    <!--[if mso]>
                    <tr>
                    <td style="padding: 18px 20px; background-color: #f9f9f9; border-radius: 10px; margin-bottom: 25px;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                    <td style="width: 32px; vertical-align: top;">
                    <![endif]-->
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">Leia e aceite os termos do contrato de parceria</div>
                    </div>
                    <!--[if mso]>
                    </td>
                    </tr>
                    </table>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </div>

                <p>O link abaixo é exclusivo para seu estabelecimento. Por favor, complete o processo o quanto antes:</p>

                <div class="credentials">
                    <p><strong>🔗 Link de acesso seguro:</strong> <a href="{{ route('establishment.onboarding', ['token' => $onboarding->token]) }}" style="color: #2989d8; text-decoration: underline;">Completar Cadastro</a></p>
                </div>

                <p>Se você tiver qualquer dúvida ou precisar de suporte, nossa equipe estará sempre disponível para ajudar. Basta responder a este e-mail ou entrar em contato através do nosso canal de suporte.</p>

                <p>Na página de cadastro, você encontrará um vídeo especial de apresentação que preparamos para que você conheça melhor o SeguraEssa e todos os benefícios que nossa parceria pode trazer para seu estabelecimento.</p>

                <div class="button-container">
                    <!--[if mso]>
                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ route('establishment.onboarding', ['token' => $onboarding->token]) }}" style="height:50px;v-text-anchor:middle;width:200px;" arcsize="10%" stroke="f" fillcolor="#1e5799">
                    <w:anchorlock/>
                    <center>
                    <![endif]-->
                    <a href="{{ route('establishment.onboarding', ['token' => $onboarding->token]) }}" class="button">Completar Meu Cadastro</a>
                    <!--[if mso]>
                    </center>
                    </v:roundrect>
                    <![endif]-->
                </div>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
                <p>Este e-mail foi enviado para {{ $establishment->email ?? 'você' }}</p>
                <p><small>Se você recebeu este e-mail por engano, por favor desconsidere-o.</small></p>
            </div>
        </div>
    </div>
    <!--[if mso]>
    </td>
    </tr>
    </table>
    <![endif]-->
</body>
</html>
