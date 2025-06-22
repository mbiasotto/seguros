@extends('layouts.site')

@section('title', 'Suporte - Multiplic.cc')

@section('content')
    <!-- Header Section -->
    <section class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Suporte ao Cliente</h1>
                    <p class="lead">Estamos aqui para ajudar você 24 horas por dia, 7 dias por semana</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Canais de Atendimento -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-4">Escolha o canal de atendimento</h2>
                <p class="lead text-muted">Oferecemos diferentes formas de contato para sua comodidade</p>
            </div>

            <div class="row g-4 mb-5">
                <!-- WhatsApp -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center support-card">
                        <div class="card-body p-5">
                            <div class="support-icon bg-success rounded-circle mx-auto mb-4">
                                <i class="fab fa-whatsapp text-white"></i>
                            </div>
                            <h4 class="fw-bold mb-3">WhatsApp</h4>
                            <p class="text-muted mb-4">Atendimento rápido e prático pelo WhatsApp. Disponível 24h.</p>
                            <div class="mb-4">
                                <div class="badge bg-success mb-2">24h por dia</div>
                                <div class="badge bg-secondary">Resposta imediata</div>
                            </div>
                            <a href="https://wa.me/5511999999999?text=Olá! Preciso de ajuda com o cartão Multiplic.cc"
                               class="btn btn-success btn-lg fw-bold w-100" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>Abrir WhatsApp
                            </a>
                            <p class="small text-muted mt-3 mb-0">
                                <i class="fas fa-phone me-2"></i>(11) 99999-9999
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Telefone -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center support-card">
                        <div class="card-body p-5">
                            <div class="support-icon bg-primary rounded-circle mx-auto mb-4">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Telefone</h4>
                            <p class="text-muted mb-4">Fale diretamente com nossos atendentes especializados.</p>
                            <div class="mb-4">
                                <div class="badge bg-primary mb-2">Seg à Sex: 8h às 18h</div>
                                <div class="badge bg-secondary">Sáb: 8h às 14h</div>
                            </div>
                            <a href="tel:+551133333333" class="btn btn-primary btn-lg fw-bold w-100">
                                <i class="fas fa-phone me-2"></i>Ligar Agora
                            </a>
                            <p class="small text-muted mt-3 mb-0">
                                <i class="fas fa-phone me-2"></i>(11) 3333-3333
                            </p>
                        </div>
                    </div>
                </div>

                <!-- E-mail -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center support-card">
                        <div class="card-body p-5">
                            <div class="support-icon bg-warning rounded-circle mx-auto mb-4">
                                <i class="fas fa-envelope text-dark"></i>
                            </div>
                            <h4 class="fw-bold mb-3">E-mail</h4>
                            <p class="text-muted mb-4">Envie sua dúvida por e-mail e receba uma resposta detalhada.</p>
                            <div class="mb-4">
                                <div class="badge bg-warning text-dark mb-2">Resposta em 24h</div>
                                <div class="badge bg-secondary">Suporte completo</div>
                            </div>
                            <a href="mailto:suporte@multiplic.cc" class="btn btn-warning btn-lg fw-bold text-dark w-100">
                                <i class="fas fa-envelope me-2"></i>Enviar E-mail
                            </a>
                            <p class="small text-muted mt-3 mb-0">
                                <i class="fas fa-envelope me-2"></i>suporte@multiplic.cc
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulário de Contato Rápido -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="fw-bold mb-4 text-center">Contato Rápido</h3>
                            <p class="text-center text-muted mb-4">
                                Ou preencha o formulário abaixo e entraremos em contato com você
                            </p>

                            <form action="{{ route('site.contato.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nome *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Telefone *</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Tipo de Solicitação *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Selecione...</option>
                                        <option value="Bloqueio de Cartão">🔒 Bloqueio de Cartão (Urgente)</option>
                                        <option value="Problemas com Compras">🛒 Problemas com Compras</option>
                                        <option value="Dúvidas sobre Fatura">💰 Dúvidas sobre Fatura</option>
                                        <option value="Alteração de Dados">📝 Alteração de Dados</option>
                                        <option value="Segunda Via do Cartão">💳 Segunda Via do Cartão</option>
                                        <option value="Cancelamento">❌ Cancelamento</option>
                                        <option value="Outros">❓ Outros</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Mensagem *</label>
                                    <textarea class="form-control" id="message" name="message" rows="4"
                                              placeholder="Descreva sua solicitação com o máximo de detalhes possível..." required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-warning btn-lg fw-bold text-dark px-5">
                                        <i class="fas fa-paper-plane me-2"></i>Enviar Solicitação
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Emergências -->
    <section class="py-5 bg-danger text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class="fas fa-exclamation-triangle me-3"></i>Em caso de emergência
                    </h3>
                    <p class="mb-0 lead">
                        Se seu cartão foi perdido, roubado ou você suspeita de uso indevido,
                        entre em contato <strong>imediatamente</strong> pelo WhatsApp 24h.
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <a href="https://wa.me/5511999999999?text=🚨 EMERGÊNCIA - Cartão Multiplic.cc"
                       class="btn btn-light btn-lg fw-bold" target="_blank">
                        <i class="fab fa-whatsapp me-2 text-success"></i>
                        <span class="text-dark">WhatsApp Emergência</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Status do Atendimento -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="fw-bold mb-4">Status do Atendimento</h3>
                <p class="text-muted">Nossos canais de atendimento estão funcionando normalmente</p>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-0 text-center">
                        <div class="card-body p-4">
                            <div class="status-indicator bg-success rounded-circle mx-auto mb-3"></div>
                            <h5 class="fw-bold">WhatsApp</h5>
                            <p class="text-success mb-0">
                                <i class="fas fa-check-circle me-2"></i>Online
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 text-center">
                        <div class="card-body p-4">
                            <div class="status-indicator bg-success rounded-circle mx-auto mb-3"></div>
                            <h5 class="fw-bold">Central Telefônica</h5>
                            <p class="text-success mb-0">
                                <i class="fas fa-check-circle me-2"></i>Funcionando
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 text-center">
                        <div class="card-body p-4">
                            <div class="status-indicator bg-success rounded-circle mx-auto mb-3"></div>
                            <h5 class="fw-bold">Sistema E-mail</h5>
                            <p class="text-success mb-0">
                                <i class="fas fa-check-circle me-2"></i>Operacional
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Links Úteis -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="fw-bold mb-4">Links Úteis</h3>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-question-circle text-warning fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Central de Ajuda</h5>
                            <p class="text-muted mb-3">Encontre respostas para as dúvidas mais comuns</p>
                            <a href="{{ route('site.ajuda') }}" class="btn btn-outline-warning">
                                Acessar FAQ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-store text-warning fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Rede Credenciada</h5>
                            <p class="text-muted mb-3">Veja onde você pode usar seu cartão</p>
                            <a href="{{ route('site.rede') }}" class="btn btn-outline-warning">
                                Ver Estabelecimentos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-file-alt text-warning fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Termos de Uso</h5>
                            <p class="text-muted mb-3">Conheça as condições de uso do cartão</p>
                            <a href="{{ route('site.termos') }}" class="btn btn-outline-warning">
                                Ler Termos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-shield-alt text-warning fs-1 mb-3"></i>
                            <h5 class="fw-bold mb-3">Privacidade</h5>
                            <p class="text-muted mb-3">Saiba como protegemos seus dados</p>
                            <a href="{{ route('site.privacidade') }}" class="btn btn-outline-warning">
                                Ver Política
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Styles -->
    <style>
        .support-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .support-card:hover {
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .status-indicator {
            width: 20px;
            height: 20px;
        }

        .badge {
            font-size: 0.75rem;
        }
    </style>
@endsection
