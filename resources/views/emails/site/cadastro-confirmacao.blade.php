<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Cadastro Realizado com Sucesso - Multiplic.cc</title>
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
            background: linear-gradient(135deg, #FFC107 0%, #FFB300 50%, #FF8F00 100%);
            color: #333;
        }

        .header h1 {
            color: #333;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .header p {
            color: rgba(51, 51, 51, 0.8);
            margin: 10px 0 0;
            font-size: 16px;
        }

        /* Conteúdo */
        .content {
            padding: 40px 30px;
        }

        h2 {
            color: #FF8F00;
            font-size: 22px;
            margin: 0 0 20px;
            font-weight: 600;
        }

        p {
            margin: 0 0 20px;
            font-size: 16px;
            color: #505050;
        }

        /* Informações do cadastro */
        .cadastro-info {
            background-color: rgba(255, 193, 7, 0.1);
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            border-left: 5px solid #FFC107;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .cadastro-info p {
            margin: 10px 0;
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            background-color: #FF8F00;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin: 15px 0;
        }

        /* Próximos passos */
        .next-steps {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
        }

        .next-steps h3 {
            color: #333;
            font-size: 18px;
            margin: 0 0 15px;
            font-weight: 600;
        }

        .next-steps ol {
            margin: 0;
            padding-left: 20px;
        }

        .next-steps li {
            margin-bottom: 10px;
            color: #555;
        }

        /* Footer */
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsivo */
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }

            .header, .content, .footer {
                padding: 20px;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <h1>Multiplic.cc</h1>
                <p>Seu cadastro foi realizado com sucesso!</p>
            </div>

            <div class="content">
                <h2>Olá, {{ $cadastro->nome }}!</h2>

                <p>É com grande satisfação que confirmamos o recebimento do seu cadastro na plataforma Multiplic.cc.</p>

                <p>Seus dados foram registrados com sucesso e estão sendo analisados pela nossa equipe.</p>

                <div class="cadastro-info">
                    <h3>📋 Dados do seu cadastro:</h3>
                    <p><strong>Nome:</strong> {{ $cadastro->nome }}</p>
                    <p><strong>E-mail:</strong> {{ $cadastro->email }}</p>
                    <p><strong>CPF:</strong> {{ $cadastro->cpf_formatado }}</p>
                    <p><strong>Telefone:</strong> {{ $cadastro->telefone_formatado }}</p>
                    <p><strong>Endereço:</strong> {{ $cadastro->endereco_completo }}</p>
                    <p><strong>Status:</strong> <span class="status-badge">{{ ucfirst($cadastro->status) }}</span></p>
                </div>

                <div class="next-steps">
                    <h3>📝 Próximos passos:</h3>
                    <ol>
                        <li><strong>Análise:</strong> Nossa equipe analisará seus dados e documentação</li>
                        <li><strong>Verificação:</strong> Faremos a verificação das informações fornecidas</li>
                        <li><strong>Aprovação:</strong> Você receberá um e-mail de confirmação quando seu cadastro for aprovado</li>
                        <li><strong>Ativação:</strong> Após a aprovação, seu cartão será ativado e enviado</li>
                    </ol>
                </div>

                <p><strong>Tempo estimado:</strong> O processo de análise leva de 1 a 3 dias úteis.</p>

                <p>Caso tenha alguma dúvida ou precise de assistência, nossa equipe de suporte está à disposição.</p>

                <p><strong>📞 Suporte:</strong></p>
                <p>
                    WhatsApp: (11) 99999-9999<br>
                    E-mail: suporte@multiplic.cc<br>
                    Horário: Segunda a sexta, das 8h às 18h
                </p>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Multiplic.cc - Todos os direitos reservados</p>
                <p>Este e-mail foi enviado para {{ $cadastro->email }}</p>
                <p><small>Se você recebeu este e-mail por engano, por favor desconsidere-o.</small></p>
            </div>
        </div>
    </div>
</body>
</html>
