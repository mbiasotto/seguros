@extends('layouts.site')

@section('title', 'Central de Ajuda - Multiplic.cc')

@section('content')
    <!-- Header Section -->
    <section class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Central de Ajuda</h1>
                    <p class="lead">Encontre respostas para suas dúvidas sobre o Multiplic.cc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" placeholder="Digite sua dúvida..." id="searchFAQ">
                        <button class="btn btn-warning text-dark fw-bold" type="button">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Categorias Principais -->
                <div class="col-lg-3 mb-5">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Categorias</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="#solicitacao" class="text-decoration-none category-link">
                                        <i class="fas fa-credit-card text-warning me-2"></i>Solicitação do Cartão
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#uso" class="text-decoration-none category-link">
                                        <i class="fas fa-shopping-bag text-warning me-2"></i>Como Usar
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#conta" class="text-decoration-none category-link">
                                        <i class="fas fa-user text-warning me-2"></i>Minha Conta
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#pagamento" class="text-decoration-none category-link">
                                        <i class="fas fa-bill text-warning me-2"></i>Pagamentos
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#problemas" class="text-decoration-none category-link">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Problemas
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#seguranca" class="text-decoration-none category-link">
                                        <i class="fas fa-shield-alt text-warning me-2"></i>Segurança
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQs -->
                <div class="col-lg-9">
                    <!-- Solicitação do Cartão -->
                    <div id="solicitacao" class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-credit-card me-2"></i>Solicitação do Cartão
                        </h3>

                        <div class="accordion accordion-flush" id="accordionSolicitacao">
                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Como solicitar o cartão Multiplic.cc?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#accordionSolicitacao">
                                    <div class="accordion-body">
                                        <p>Para solicitar seu cartão Multiplic.cc, siga estes passos:</p>
                                        <ol>
                                            <li>Acesse nossa <a href="{{ route('site.cadastro') }}" class="text-warning">página de cadastro</a></li>
                                            <li>Preencha todos os seus dados pessoais</li>
                                            <li>Informe o número da sua conta CPFL</li>
                                            <li>Aguarde a análise (resposta em até 5 minutos)</li>
                                            <li>Receba seu cartão em casa em até 7 dias úteis</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Quais documentos preciso para solicitar?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionSolicitacao">
                                    <div class="accordion-body">
                                        <p>Você precisa ter em mãos:</p>
                                        <ul>
                                            <li>CPF válido</li>
                                            <li>RG ou CNH</li>
                                            <li>Comprovante de endereço atualizado</li>
                                            <li>Conta de energia elétrica da CPFL</li>
                                            <li>Telefone celular ativo</li>
                                            <li>E-mail válido</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Posso solicitar mesmo estando negativado?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionSolicitacao">
                                    <div class="accordion-body">
                                        <p><strong>Sim!</strong> O cartão Multiplic.cc foi criado especialmente para pessoas que estão com restrições no CPF. Não consultamos SPC ou Serasa para aprovação. O importante é ter uma conta ativa na CPFL.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Como Usar -->
                    <div id="uso" class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-shopping-bag me-2"></i>Como Usar
                        </h3>

                        <div class="accordion accordion-flush" id="accordionUso">
                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#uso1">
                                        Como funciona o cartão?
                                    </button>
                                </h2>
                                <div id="uso1" class="accordion-collapse collapse" data-bs-parent="#accordionUso">
                                    <div class="accordion-body">
                                        <p>O cartão Multiplic.cc é pré-pago e funciona da seguinte forma:</p>
                                        <ol>
                                            <li>Você define um limite mensal conforme sua capacidade</li>
                                            <li>Use o cartão normalmente nos estabelecimentos credenciados</li>
                                            <li>O valor das compras é automaticamente debitado na sua conta de luz</li>
                                            <li>Sem surpresas: você só gasta o que pode pagar</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#uso2">
                                        Onde posso usar o cartão?
                                    </button>
                                </h2>
                                <div id="uso2" class="accordion-collapse collapse" data-bs-parent="#accordionUso">
                                    <div class="accordion-body">
                                        <p>Você pode usar em nossa <a href="{{ route('site.rede') }}" class="text-warning">rede credenciada</a> que inclui:</p>
                                        <ul>
                                            <li>Supermercados (Pão de Açúcar, Carrefour, Extra)</li>
                                            <li>Farmácias (Droga Raia, Drogasil, Pacheco)</li>
                                            <li>Postos de combustível (Shell, BR, Ipiranga)</li>
                                            <li>Restaurantes (McDonald's, Domino's, Starbucks)</li>
                                            <li>E muito mais!</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Minha Conta -->
                    <div id="conta" class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-user me-2"></i>Minha Conta
                        </h3>

                        <div class="accordion accordion-flush" id="accordionConta">
                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#conta1">
                                        Como acompanhar meus gastos?
                                    </button>
                                </h2>
                                <div id="conta1" class="accordion-collapse collapse" data-bs-parent="#accordionConta">
                                    <div class="accordion-body">
                                        <p>Você pode acompanhar seus gastos através:</p>
                                        <ul>
                                            <li>App Multiplic.cc (em breve)</li>
                                            <li>SMS após cada compra</li>
                                            <li>E-mail com extrato mensal</li>
                                            <li>Atendimento por WhatsApp</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagamentos -->
                    <div id="pagamento" class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-bill me-2"></i>Pagamentos
                        </h3>

                        <div class="accordion accordion-flush" id="accordionPagamento">
                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pag1">
                                        Como é feito o pagamento?
                                    </button>
                                </h2>
                                <div id="pag1" class="accordion-collapse collapse" data-bs-parent="#accordionPagamento">
                                    <div class="accordion-body">
                                        <p>O pagamento é <strong>100% automático</strong>:</p>
                                        <ul>
                                            <li>Os valores das suas compras são somados mensalmente</li>
                                            <li>O total é incluído automaticamente na sua conta de luz da CPFL</li>
                                            <li>Você paga tudo junto, sem juros ou taxas extras</li>
                                            <li>Praticidade total: uma conta só!</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Problemas -->
                    <div id="problemas" class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>Problemas
                        </h3>

                        <div class="accordion accordion-flush" id="accordionProblemas">
                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prob1">
                                        O que fazer se o cartão for perdido ou roubado?
                                    </button>
                                </h2>
                                <div id="prob1" class="accordion-collapse collapse" data-bs-parent="#accordionProblemas">
                                    <div class="accordion-body">
                                        <p><strong>Entre em contato imediatamente:</strong></p>
                                        <ul>
                                            <li>WhatsApp: (11) 99999-9999 (disponível 24h)</li>
                                            <li>Telefone: (11) 3333-3333</li>
                                            <li>E-mail: emergencia@multiplic.cc</li>
                                        </ul>
                                        <p>Faremos o bloqueio imediato e enviaremos um novo cartão sem custo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Segurança -->
                    <div id="seguranca" class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-shield-alt me-2"></i>Segurança
                        </h3>

                        <div class="accordion accordion-flush" id="accordionSeguranca">
                            <div class="accordion-item border rounded mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#seg1">
                                        Meus dados estão seguros?
                                    </button>
                                </h2>
                                <div id="seg1" class="accordion-collapse collapse" data-bs-parent="#accordionSeguranca">
                                    <div class="accordion-body">
                                        <p>Sim! Utilizamos as mais avançadas tecnologias de segurança:</p>
                                        <ul>
                                            <li>Criptografia de dados bancários</li>
                                            <li>Servidores seguros certificados</li>
                                            <li>Conformidade com LGPD</li>
                                            <li>Parceria oficial com CPFL</li>
                                            <li>Monitoramento 24h por dia</li>
                                        </ul>
                                        <p>Leia nossa <a href="{{ route('site.privacidade') }}" class="text-warning">Política de Privacidade</a> para mais detalhes.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Não encontrou? -->
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body p-5 text-center">
                            <h4 class="fw-bold mb-3">Não encontrou o que procurava?</h4>
                            <p class="mb-4">Nossa equipe está pronta para ajudar você!</p>
                            <div class="row justify-content-center">
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('site.contato') }}" class="btn btn-warning btn-lg fw-bold text-dark w-100">
                                        <i class="fas fa-envelope me-2"></i>Enviar Mensagem
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="https://wa.me/5511999999999" class="btn btn-success btn-lg fw-bold w-100" target="_blank">
                                        <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="tel:+551133333333" class="btn btn-primary btn-lg fw-bold w-100">
                                        <i class="fas fa-phone me-2"></i>Ligar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Styles -->
    <style>
        .category-link {
            color: #666;
            transition: all 0.3s ease;
        }
        .category-link:hover {
            color: #ffc107;
            padding-left: 10px;
        }
        .accordion-button:not(.collapsed) {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>

    <!-- Scripts -->
    <script>
        // Smooth scroll para as categorias
        document.querySelectorAll('.category-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Busca simples nos FAQs
        document.getElementById('searchFAQ').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const questions = document.querySelectorAll('.accordion-button');

            questions.forEach(question => {
                const text = question.textContent.toLowerCase();
                const accordionItem = question.closest('.accordion-item');

                if (text.includes(searchTerm) || searchTerm === '') {
                    accordionItem.style.display = 'block';
                } else {
                    accordionItem.style.display = 'none';
                }
            });
        });
    </script>
@endsection
