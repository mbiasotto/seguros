<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete seu cadastro - SeguraEssa.app</title>
    <link rel="icon" href="{{ asset('assets/admin/img/favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/establishments/onboarding.css') }}">
</head>
<body>
    <div class="onboarding-container">
        <div class="header">
            <img src="{{ asset('assets/admin/img/logo-white.png') }}" alt="SeguraEssa.app Logo">
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
                    <div class="step-title">Termos</div>
                </div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-title">Conclusão</div>
                </div>
            </div>

            <div class="mb-4">
                <h2>Olá, {{ $establishment->nome }}!</h2>
                <p>Para finalizar seu cadastro como parceiro do SeguraEssa.app, precisamos que você aceite nossos termos de contrato.</p>
            </div>

            <div class="video-container mb-4">
                <h3><i class="fas fa-video me-2"></i> Assista ao vídeo explicativo</h3>
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/op4wAl92lNo" title="Vídeo explicativo" allowfullscreen></iframe>
                </div>
            </div>

            <form action="{{ route('establishment.onboarding.process', ['token' => $onboarding->token]) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                <div class="form-section">
                    <h3><i class="fas fa-file-contract me-2"></i> Termo de Cessão de Espaço Publicitário</h3>
                    <p>Por favor, leia atentamente os termos do contrato abaixo:</p>

                    <div class="contract-text">
                        <h4>TERMO DE CESSÃO DE ESPAÇO PUBLICITÁRIO</h4>

                        <p>Este Contrato de Cessão de Espaço Publicitário é celebrado, entre as partes:</p>

                        <p><strong>Cessionário:</strong> CÂMARA E GARUTTI CORRETORA E ADMINISTRADORA DE SEGUROS LTDA, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº. 20.641.367/0001-00, com sede na Av. Rudolf Dafferner, 400 – Bloco São Paulo – Sala 415 – Bairro Alato da Boa Vista - Sorocaba/SP CEP 18085-005, neste ato representado na forma de seus atos constitutivos, doravante denominado simplesmente Cessionário.</p>

                        <p><strong>Cedente (Estabelecimento):</strong> {{ $establishment->nome }}, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº. {{ $establishment->cnpj ?? '[Número do CNPJ]' }}, com sede em {{ $establishment->endereco ?? '[endereço completo]' }}, neste ato representado na forma de seus atos constitutivos, doravante denominado simplesmente Cedente.</p>

                        <p><strong>Considerando que:</strong></p>
                        <ul>
                            <li>O Cedente é proprietário e/ou legítimo possuidor do estabelecimento comercial localizado em {{ $establishment->endereco ?? '[endereço do estabelecimento]' }};</li>
                            <li>O Cessionário tem interesse em divulgar seus produtos e serviços (seguros variados, planos de saúde, consórcios, Capitalização, Sorteios, etc.) nos endereços físicos e eletrônicos de estabelecimentos comerciais, prestação de serviços, associações, sindicatos, condomínios residenciais/comerciais, através de adesivos, QRCODE, links, entre outras formas que serão préviamente apresentadas ao Cedente para aprovação.</li>
                            <li>As partes desejam formalizar a cessão de espaço para fins publicitários.</li>
                        </ul>

                        <p>As partes acima identificadas, em comum acordo, resolvem celebrar o presente contrato, que se regerá pelas cláusulas e condições seguintes:</p>

                        <h5>Cláusula 1ª – Objeto</h5>
                        <p>1.1. O Cedente cede ao Cessionário, a título exclusivo para os produtos quem fazem parte do portfólio de produtos do Cessionário nos locais de sua propridade ou de sua responsabilidade (locais alugados, filiais, participação em eventos e materiais de publicidade), endereços eletrônicos (sites, redes sociais, e-mals, entre outros) para a divulgação de produtos e serviços do Cessionário (seguros de diversos ramos, planos de saúde, consórcios, produtos financeiros, capitalização, que estarão disponíveis no site do Cessionário);</p>
                        <p>1.2. O Cessionário se compromete a utilizar o espaço cedido exclusivamente para fins de divulgação, sendo vedada a realização de qualquer outra atividade, como a venda direta ou a prestação de serviços no local.</p>

                        <h5>Cláusula 2ª – Retribuição</h5>
                        <p>2.1. A retribuição pela cessão do espaço será baseada nas indicações de clientes e nos contratos gerados, efetivados e que estejm com parcelas e/ou mensalidades pagas em seus respectivos vencimentos conforme regras do produto e /ou servico contratato.</p>
                        <p>2.2. O controle da divulgação e acesso aos produtos, serão por meio do QR code e links para acesso eletrônico.</p>
                        <p>2.3. O QR code e links serão exclusivo do Cedente, não podendo o mesmo utiilizar ou ceder para outra empresa.</p>
                        <p>2.4. A retribuição será paga ao Cedente mensalmente, conforme tabela do ANEXO I deste termo;</p>
                        <p>2.5. Sobre o valor da retribuição incidirão os descontos de impostos devidos, conforme a legislação vigente, conforme tabela do ANEXO I deste termo.</p>

                        <h5>Cláusula 3ª – Obrigações do Cedente</h5>
                        <p>3.1. Disponibilizar o espaço cedido nas condições estabelecidas neste contrato.</p>
                        <p>3.2. Permitir a instalação de materiais de divulgação do Cessionário no espaço cedido, desde que previamente aprovados pelo Cedente.</p>
                        <p>3.3. Não interferir nas atividades de divulgação do Cessionário, desde que estas estejam em conformidade com as normas e regulamentos do estabelecimento. Se algum interessado quiser saber de informaçoes e detalhes dos produtos, deverá procurar o Cessionário para que possa sanar as dúvidas e seguir toda regulamentação pertinentes a cada produto.</p>

                        <h5>Cláusula 4ª – Obrigações do Cessionário</h5>
                        <p>4.1. Utilizar o espaço cedido exclusivamente para fins de divulgação de seus produtos e serviços.</p>
                        <p>4.2. Manter o espaço cedido limpo e organizado.</p>
                        <p>4.3. Respeitar as normas e regulamentos do estabelecimento.</p>
                        <p>4.4. Não ceder ou transferir a terceiros os direitos e obrigações decorrentes deste contrato.</p>
                        <p>4.5. Comunicar ao Cedente, por escrito, qualquer alteração em seus produtos ou serviços divulgados no espaço cedido.</p>

                        <h5>Cláusula 5ª – Prazo e Rescisão</h5>
                        <p>5.1. O presente contrato terá vigência de 12 (doze) meses, a contar da data de sua assinatura, podendo ser rescindido por qualquer das partes, mediante aviso prévio de 30 (trinta) dias, por escrito.</p>
                        <p>5.2. Após o período inicial, o contrato será prorrogado automaticamente por prazo indeterminado, caso não haja manifestação expressa de encerramento por qualquer das partes, por escrito, com antecedência mínima de 30 (trinta) dias.</p>
                        <p>5.3. Em caso de rescisão, o Cessionário deverá remover todos os seus materiais de divulgação do espaço cedido no prazo de 10 (dez) dias úteis, contados da data da notificação da rescisão.</p>

                        <h5>Cláusula 6ª – Disposições Gerais</h5>
                        <p>6.1. Este contrato não estabelece qualquer vínculo empregatício, societário ou de representação entre as partes, sendo cada qual responsável por suas próprias obrigações e encargos.</p>
                        <p>6.2. As partes se comprometem a manter o sigilo das informações confidenciais trocadas durante a vigência deste contrato, mesmo após a sua rescisão pelo prazo de 36 meses.</p>
                        <p>6.3. Fica eleito o foro da comarca de Sorocaba/SP para dirimir quaisquer dúvidas ou litígios decorrentes deste contrato, com renúncia expressa a qualquer outro, por mais privilegiado que seja.</p>

                        <p>Sorocaba/SP, {{ date('Y-m-d') }}.</p>

                        <p>CÂMARA E GARUTTI CORRETORA E ADMINISTRADORA DE SEGUROS LTDA (Cessionário)</p>
                        <p>{{ $establishment->nome }} (Cedente)</p>

                        <h5>Anexo I</h5>
                        <h6>Tabela de Retribuição por clientes advindos pela Cessão de Espaço</h6>

                        <p><strong>Apuração das indicações através do espaço cedido:</strong></p>
                        <p>Serão contabilizadas todas as apólices e/ou serviços/produtos contratados emitidas e pagas do dia 01 até o dia 30 do mês. A apuração das vendas será mensal. O Cedente receberá um extrato das indicações que geraram contratos efetivos.</p>

                        <p><strong>Pagamento das retribuições:</strong></p>
                        <ol>
                            <li>Será realizado no mês subsequente na conta corrente em nome do Cedente.</li>
                            <li>A Retribuição Cessionário segue as movimentações do cliente apresentado, ou seja, caso o cliente deixe de utilizar quaisquer das formas de operacionalização, serviços ou cancelamento de seguros e serviços fornecidos pelo Cessionário, o Cedente deixa de auferir os rendimentos referentes ao cliente indicado/captado através o espaço cedido, a partir do período em que cessa a utilização.</li>
                        </ol>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th>Comissão</th>
                                        <th>Observação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Seguros - todos os ramos</td>
                                        <td>10%</td>
                                        <td>Da comissão da corretora e dedução de tributos 15%</td>
                                    </tr>
                                    <tr>
                                        <td>Planos Saúde/Dental</td>
                                        <td>10%</td>
                                        <td>Da comissão da corretora e dedução de tributos 15% após término da regra do estorno de comissão da operadora/seguradora a qual contrato será efetivado</td>
                                    </tr>
                                    <tr>
                                        <td>Financiamento Auto</td>
                                        <td>10%</td>
                                        <td>Da comissão da corretora e dedução de impostos 18%</td>
                                    </tr>
                                    <tr>
                                        <td>Consórcios</td>
                                        <td>10%</td>
                                        <td>Da comissão da corretora e dedução de tributos 18% após término da regra do estorno de comissão da operadora a qual contrato será efetivado</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input @error('contract_accepted') is-invalid @enderror" id="contract_accepted" name="contract_accepted" required>
                        <label class="form-check-label" for="contract_accepted">Li e aceito os termos do contrato acima</label>
                        @error('contract_accepted')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campos ocultos para validação legal do aceite -->
                    <input type="hidden" name="user_ip" id="user_ip" value="{{ request()->ip() }}">
                    <input type="hidden" name="user_agent" id="user_agent" value="{{ request()->userAgent() }}">
                    <input type="hidden" name="accepted_timestamp" id="accepted_timestamp" value="{{ now()->timestamp }}">
                    <input type="hidden" name="contract_version" value="1.0">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Aceitar Termos e Finalizar Cadastro</button>
                </div>
            </form>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SeguraEssa.app - Todos os direitos reservados</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        // Captura dados adicionais para validação legal do aceite
        document.addEventListener('DOMContentLoaded', function() {
            // Registrar quando o usuário visualizou o contrato
            let contractViewTime = new Date().toISOString();
            let contractElement = document.querySelector('.contract-text');
            let isContractFullyRead = false;
            let scrollCompletedField = document.createElement('input');
            scrollCompletedField.type = 'hidden';
            scrollCompletedField.id = 'contract_scroll_completed';
            scrollCompletedField.name = 'contract_scroll_completed';
            scrollCompletedField.value = 'false'; // Inicia como falso
            document.querySelector('form').appendChild(scrollCompletedField);

            // Monitorar rolagem do contrato
            contractElement.addEventListener('scroll', function() {
                if (!isContractFullyRead && (contractElement.scrollHeight - contractElement.scrollTop <= contractElement.clientHeight + 50)) {
                    isContractFullyRead = true;
                    document.getElementById('contract_scroll_completed').value = 'true';
                }
            });

            // Adicionar campos ocultos adicionais no envio do formulário
            document.querySelector('form').addEventListener('submit', function() {
                // Tempo total de permanência na página
                let timeSpentOnPage = Math.floor((new Date() - new Date(contractViewTime)) / 1000);
                let timeSpentField = document.createElement('input');
                timeSpentField.type = 'hidden';
                timeSpentField.name = 'time_spent_viewing_contract';
                timeSpentField.value = timeSpentOnPage;
                this.appendChild(timeSpentField);

                // Gerar hash único para esta aceitação
                let acceptanceId = 'acceptance_' + Math.random().toString(36).substring(2, 9) + '_' + new Date().getTime();
                let acceptanceField = document.createElement('input');
                acceptanceField.type = 'hidden';
                acceptanceField.name = 'acceptance_id';
                acceptanceField.value = acceptanceId;
                this.appendChild(acceptanceField);
            });
        });
    </script>
</body>
</html>
