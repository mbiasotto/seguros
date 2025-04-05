@extends('site.layouts.site')

@section('title', 'Câmara & Garutti - Seguros e Financiamentos com até 30% de Desconto')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="tear-effect"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-text" data-aos="fade-right">
                <h1 class="hero-title mb-3">Seguros e Financiamentos com até 30% de Desconto</h1>
                <p class="hero-subtitle mb-4">Economize tempo e dinheiro com as melhores condições do mercado</p>
                <div class="d-flex gap-3">
                    <a href="#contato" class="btn btn-light btn-lg fw-bold px-4 py-3 rounded-pill shadow-sm">Quero Economizar</a>
                    <a href="#como-funciona" class="btn btn-outline-light btn-lg fw-bold px-4 py-3 rounded-pill">Como Funciona</a>
                </div>
            </div>
            <div class="col-lg-6 hero-image" data-aos="fade-left">
                <img src="/img/hero-image.svg" alt="Seguros e Financiamentos" class="img-fluid">
                <div class="discount-badge">
                    <span class="discount-text">Até</span>
                    <span class="discount-value">30%</span>
                    <span class="discount-text">OFF</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section py-5" id="servicos">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Nossos Serviços</h2>
            <p class="section-subtitle">Conheça as soluções que oferecemos com condições exclusivas</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3 class="service-title">Seguro Auto</h3>
                    <p class="service-description">Proteção completa para seu veículo com as melhores coberturas e assistência 24h.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i> Cobertura contra roubo e furto</li>
                        <li><i class="fas fa-check-circle"></i> Assistência 24 horas</li>
                        <li><i class="fas fa-check-circle"></i> Carro reserva</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="service-title">Seguro Residencial</h3>
                    <p class="service-description">Tranquilidade para sua família com proteção completa para sua casa.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i> Cobertura contra incêndio</li>
                        <li><i class="fas fa-check-circle"></i> Proteção contra danos elétricos</li>
                        <li><i class="fas fa-check-circle"></i> Assistência 24 horas</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="service-title">Seguro Saúde</h3>
                    <p class="service-description">Cuide da saúde da sua família com planos completos e rede credenciada de qualidade.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i> Ampla rede credenciada</li>
                        <li><i class="fas fa-check-circle"></i> Cobertura nacional</li>
                        <li><i class="fas fa-check-circle"></i> Telemedicina</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works-section py-5" id="como-funciona">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Como Funciona</h2>
            <p class="section-subtitle">Processo simples e rápido para você economizar</p>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card text-center">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="step-title">Entre em Contato</h3>
                    <p class="step-description">Preencha o formulário ou entre em contato pelo WhatsApp.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card text-center">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="step-title">Análise Personalizada</h3>
                    <p class="step-description">Nossos consultores analisam seu perfil e necessidades.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card text-center">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h3 class="step-title">Melhores Ofertas</h3>
                    <p class="step-description">Receba propostas com descontos exclusivos.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="step-card text-center">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="step-title">Contratação Facilitada</h3>
                    <p class="step-description">Processo simplificado e suporte completo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5" id="depoimentos">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">O Que Nossos Clientes Dizem</h2>
            <p class="section-subtitle">Experiências reais de quem já economizou com a gente</p>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Economizei mais de 30% no seguro do meu carro. O atendimento foi excelente e todo o processo foi muito rápido. Super recomendo!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/avatar-1.jpg" alt="Cliente" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Carlos Silva</h4>
                            <p class="testimonial-role">Cliente Seguro Auto</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Consegui um plano de saúde com cobertura muito melhor do que eu tinha antes e ainda economizei. Os consultores são muito atenciosos e encontraram a melhor opção para minha família."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/avatar-2.jpg" alt="Cliente" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Ana Oliveira</h4>
                            <p class="testimonial-role">Cliente Seguro Saúde</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Fiz o financiamento do meu apartamento com condições muito melhores do que as que encontrei no mercado. O processo foi simples e rápido, sem burocracia."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/avatar-3.jpg" alt="Cliente" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Roberto Mendes</h4>
                            <p class="testimonial-role">Cliente Financiamento</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="partners-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Nossos Parceiros</h2>
            <p class="section-subtitle">Trabalhamos com as melhores seguradoras e instituições financeiras</p>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="partner-logo">
                    <img src="/img/partner-1.svg" alt="Parceiro" class="img-fluid">
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="partner-logo">
                    <img src="/img/partner-2.svg" alt="Parceiro" class="img-fluid">
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="partner-logo">
                    <img src="/img/partner-3.svg" alt="Parceiro" class="img-fluid">
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="partner-logo">
                    <img src="/img/partner-4.svg" alt="Parceiro" class="img-fluid">
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="500">
                <div class="partner-logo">
                    <img src="/img/partner-5.svg" alt="Parceiro" class="img-fluid">
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="600">
                <div class="partner-logo">
                    <img src="/img/partner-6.svg" alt="Parceiro" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" id="contato">
    <div class="floating-elements">
        <div class="floating-element" style="width: 100px; height: 100px; top: 10%; left: 5%;"></div>
        <div class="floating-element" style="width: 150px; height: 150px; top: 50%; left: 15%;"></div>
        <div class="floating-element" style="width: 80px; height: 80px; top: 30%; right: 10%;"></div>
        <div class="floating-element" style="width: 120px; height: 120px; bottom: 20%; right: 5%;"></div>
    </div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row">
            <div class="col-lg-6 text-white mb-5 mb-lg-0" data-aos="fade-right">
                <h2 class="display-4 fw-bold mb-4">Aproveite agora!</h2>
                <p class="lead mb-4">Preencha o formulário ao lado e um de nossos consultores entrará em contato para oferecer as melhores condições para você.</p>
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Atendimento Personalizado</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Melhores Condições do Mercado</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Economia Garantida</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="contact-form-card">
                    <h3 class="mb-4 fw-bold">Solicite uma Cotação</h3>
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefone/WhatsApp</label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="service" class="form-label">Serviço de Interesse</label>
                            <select class="form-select" id="service" required>
                                <option value="" selected disabled>Selecione uma opção</option>
                                <option value="seguro-auto">Seguro Auto</option>
                                <option value="seguro-residencial">Seguro Residencial</option>
                                <option value="seguro-saude">Seguro Saúde</option>
                                <option value="seguro-vida">Seguro de Vida</option>
                                <option value="financiamento">Financiamento</option>
                                <option value="consorcio">Consórcio</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensagem (Opcional)</label>
                            <textarea class="form-control" id="message" rows="3"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Solicitar Cotação</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
