<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete seu cadastro - SeguraEssa.app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .onboarding-container {
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
        }
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            background-color: #f8f9fa;
            border-left: 5px solid #2e86de;
        }
        .form-section h3 {
            color: #1a5276;
            margin-bottom: 15px;
        }
        .contract-text {
            max-height: 300px;
            overflow-y: auto;
            padding: 15px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.6;
        }
        .btn-primary {
            background-color: #2e86de;
            border-color: #2e86de;
            padding: 10px 20px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #1a5276;
            border-color: #1a5276;
        }
        .alert {
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
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
        .step.active .step-circle {
            background: #2e86de;
        }
        .step.completed .step-circle {
            background: #28a745;
        }
        .step-title {
            font-size: 14px;
            color: #777;
        }
        .step.active .step-title {
            color: #2e86de;
            font-weight: bold;
        }
        .step.completed .step-title {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="onboarding-container">
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="SeguraEssa.app Logo">
            <h1>Complete seu cadastro</h1>
            <p>Estamos quase lá! Siga os passos abaixo para finalizar seu cadastro.</p>
        </div>

        <div class="content">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Cadastro Inicial</div>
                </div>
                <div class="step active">
                    <div class="step-circle">2</div>
                    <div class="step-title">Documentação</div>
                </div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-title">Conclusão</div>
                </div>
            </div>

            <div class="mb-4">
                <h2>Olá, {{ $establishment->nome }}!</h2>
                <p>Para finalizar seu cadastro como parceiro do SeguraEssa.app, precisamos que você envie um documento e aceite nossos termos de contrato.</p>
            </div>

            <form action="{{ route('establishment.onboarding.process', ['token' => $onboarding->token]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                <div class="form-section">
                    <h3><i class="fas fa-file-upload me-2"></i> Upload de Documento</h3>
                    <p>Por favor, envie um documento que comprove a existência do seu estabelecimento (CNPJ, Contrato Social, etc).</p>

                    <div class="mb-3">
                        <label for="document" class="form-label">Documento (PDF, JPG, PNG - máx. 5MB)</label>
                        <input type="file" class="form-control @error('document') is-invalid @enderror" id="document" name="document" required>
                        @error('document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">O documento enviado será analisado pela nossa equipe.</div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-file-contract me-2"></i> Termos de Contrato</h3>
                    <p>Por favor, leia atentamente os termos do contrato abaixo:</p>

                    <div class="contract-text">
                        <h4>CONTRATO DE PARCERIA - SEGURAESSA.APP</h4>
                        <p>Este Contrato de Parceria ("Contrato") é celebrado entre SeguraEssa.app, doravante denominada "EMPRESA", e o estabelecimento identificado no cadastro, doravante denominado "PARCEIRO".</p>

                        <h5>1. OBJETO</h5>
                        <p>1.1. O presente Contrato tem por objeto estabelecer as condições para a parceria entre a EMPRESA e o PARCEIRO, visando a promoção e comercialização dos serviços oferecidos pela plataforma SeguraEssa.app.</p>

                        <h5>2. OBRIGAÇÕES DO PARCEIRO</h5>
                        <p>2.1. Promover os serviços da EMPRESA de forma ética e profissional.</p>
                        <p>2.2. Manter sigilo sobre as informações confidenciais da EMPRESA.</p>
                        <p>2.3. Não utilizar o nome, marca ou qualquer outro elemento de propriedade intelectual da EMPRESA sem prévia autorização por escrito.</p>
                        <p>2.4. Comunicar à EMPRESA qualquer irregularidade ou problema relacionado aos serviços.</p>

                        <h5>3. OBRIGAÇÕES DA EMPRESA</h5>
                        <p>3.1. Fornecer ao PARCEIRO as informações necessárias para a promoção dos serviços.</p>
                        <p>3.2. Pagar ao PARCEIRO as comissões acordadas, conforme estabelecido neste Contrato.</p>
                        <p>3.3. Prestar suporte técnico e comercial ao PARCEIRO.</p>

                        <h5>4. COMISSÕES</h5>
                        <p>4.1. A EMPRESA pagará ao PARCEIRO comissões sobre as vendas realizadas, conforme tabela de comissões vigente.</p>
                        <p>4.2. As comissões serão pagas mensalmente, até o 10º dia útil do mês subsequente ao da realização das vendas.</p>
                        <p>4.3. O pagamento será realizado mediante depósito bancário na conta indicada pelo PARCEIRO.</p>

                        <h5>5. VIGÊNCIA E RESCISÃO</h5>
                        <p>5.1. Este Contrato terá vigência por prazo indeterminado, podendo ser rescindido por qualquer das partes, mediante notificação prévia de 30 (trinta) dias.</p>
                        <p>5.2. O Contrato poderá ser rescindido imediatamente, sem necessidade de notificação prévia, em caso de descumprimento de qualquer de suas cláusulas.</p>

                        <h5>6. DISPOSIÇÕES GERAIS</h5>
                        <p>6.1. Este Contrato não estabelece qualquer vínculo empregatício entre as partes.</p>
                        <p>6.2. O PARCEIRO não tem poderes para representar a EMPRESA, salvo se expressamente autorizado por escrito.</p>
                        <p>6.3. Este Contrato constitui o acordo integral entre as partes e substitui todos os acordos anteriores.</p>
                        <p>6.4. Qualquer alteração deste Contrato deverá ser feita por escrito e assinada por ambas as partes.</p>

                        <h5>7. FORO</h5>
                        <p>7.1. As partes elegem o foro da Comarca de São Paulo, Estado de São Paulo, para dirimir quaisquer dúvidas ou controvérsias oriundas deste Contrato, com renúncia expressa a qualquer outro, por mais privilegiado que seja.</p>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input @error('contract_accepted') is-invalid @enderror" id="contract_accepted" name="contract_accepted" required>
                        <label class="form-check-label" for="contract_accepted">Li e aceito os termos do contrato acima</label>
                        @error('contract_accepted')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Enviar Documentação e Finalizar Cadastro</button>
                </div>
            </form>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validação do formulário
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>