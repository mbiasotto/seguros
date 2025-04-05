@extends('site.layouts.site')

@section('title', 'Seja um Vendedor | Câmara & Garutti - Ganhe comissões em dois níveis')

@section('content')
<!-- Hero Section -->
<section class="hero-section vendedor-page">
    <div class="wave-shape">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-text" data-aos="fade-right">
                <h1 class="hero-title mb-3">Seja um Vendedor e Ganhe Comissões em Dois Níveis</h1>
                <p class="hero-subtitle mb-4">Trabalhe com liberdade e construa uma rede de vendas que gera renda passiva</p>
                <div class="d-flex gap-3">
                    <a href="#cadastro" class="btn btn-light btn-lg fw-bold px-4 py-3 rounded-pill shadow-sm">Quero ser Vendedor</a>
                    <a href="#como-funciona" class="btn btn-outline-light btn-lg fw-bold px-4 py-3 rounded-pill">Como Funciona</a>
                </div>
            </div>
            <div class="col-lg-6 hero-image" data-aos="fade-left">
                <img src="/img/vendor-hero.svg" alt="Seja um Vendedor" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section py-5" id="beneficios">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Por que se tornar um Vendedor?</h2>
            <p class="section-subtitle">Vantagens exclusivas para nossos vendedores</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="benefit-card h-100">
                    <div class="benefit-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="benefit-title">Comissões Atrativas</h3>
                    <p class="benefit-description">Ganhe comissões acima do mercado em cada venda realizada e também sobre as vendas da sua rede.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="benefit-card h-100">
                    <div class="benefit-icon">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <h3 class="benefit-title">Trabalhe de Onde Quiser</h3>
                    <p class="benefit-description">Tenha liberdade para trabalhar de casa, de um café ou de qualquer lugar com acesso à internet.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="benefit-card h-100">
                    <div class="benefit-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="benefit-title">Construa sua Rede</h3>
                    <p class="benefit-description">Convide outros vendedores e ganhe comissões sobre as vendas realizadas por eles, criando uma fonte de renda passiva.</p>
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
            <p class="section-subtitle">Processo simples para começar a vender</p>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card text-center">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="step-title">Cadastre-se</h3>
                    <p class="step-description">Preencha o formulário de cadastro para se tornar um vendedor oficial.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card text-center">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="step-title">Treinamento</h3>
                    <p class="step-description">Receba treinamento completo sobre produtos, técnicas de vendas e sistema.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card text-center">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="step-title">Comece a Vender</h3>
                    <p class="step-description">Utilize nossas ferramentas e materiais para conquistar clientes.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="step-card text-center">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="step-title">Receba Comissões</h3>
                    <p class="step-description">Ganhe comissões por suas vendas e pelas vendas da sua rede.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Commission Section -->
<section class="commission-section py-5" id="comissoes">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Comissões Atrativas</h2>
            <p class="section-subtitle">Conheça nosso plano de comissionamento em dois níveis</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="commission-table-wrapper" data-aos="fade-up">
                    <table class="table commission-table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Comissão Direta</th>
                                <th>Comissão Indireta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Seguro Auto</td>
                                <td>20%</td>
                                <td>5%</td>
                            </tr>
                            <tr>
                                <td>Seguro Residencial</td>
                                <td>25%</td>
                                <td>7%</td>
                            </tr>
                            <tr>
                                <td>Seguro de Vida</td>
                                <td>30%</td>
                                <td>8%</td>
                            </tr>
                            <tr>
                                <td>Seguro Saúde</td>
                                <td>20%</td>
                                <td>5%</td>
                            </tr>
                            <tr>
                                <td>Financiamentos</td>
                                <td>1.5% do valor</td>
                                <td>0.3% do valor</td>
                            </tr>
                            <tr>
                                <td>Consórcios</td>
                                <td>1.5% do valor</td>
                                <td>0.3% do valor</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tools Section -->
<section class="tools-section py-5" id="ferramentas">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Ferramentas para seu Sucesso</h2>
            <p class="section-subtitle">Tudo o que você precisa para vender mais</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="tool-card h-100">
                    <div class="tool-icon">
                        <i class="fas fa-tablet-alt"></i>
                    </div>
                    <h3 class="tool-title">App de Vendas</h3>
                    <p class="tool-description">Aplicativo exclusivo para cotações, propostas e acompanhamento de vendas em tempo real.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="tool-card h-100">
                    <div class="tool-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="tool-title">Treinamentos</h3>
                    <p class="tool-description">Acesso a treinamentos contínuos sobre produtos, técnicas de vendas e atendimento ao cliente.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="tool-card h-100">
                    <div class="tool-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="tool-title">Materiais de Vendas</h3>
                    <p class="tool-description">Apresentações, folhetos digitais e materiais personalizados para suas abordagens.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="tool-card h-100">
                    <div class="tool-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="tool-title">Suporte Dedicado</h3>
                    <p class="tool-description">Equipe de suporte exclusiva para ajudar em dúvidas técnicas e processos de vendas.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="tool-card h-100">
                    <div class="tool-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="tool-title">Dashboard de Desempenho</h3>
                    <p class="tool-description">Acompanhe suas vendas, comissões e o desempenho da sua rede em tempo real.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                <div class="tool-card h-100">
                    <div class="tool-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="tool-title">Gestão de Equipe</h3>
                    <p class="tool-description">Ferramentas para recrutar, treinar e acompanhar o desempenho dos vendedores da sua rede.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5" id="depoimentos">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">O Que Nossos Vendedores Dizem</h2>
            <p class="section-subtitle">Experiências reais de quem já está vendendo com a gente</p>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Trabalho como vendedor há 1 ano e já construí uma equipe de 8 pessoas. A liberdade de horários e as comissões em dois níveis me proporcionam uma renda muito superior à que eu tinha no meu emprego anterior."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/vendor-1.jpg" alt="Vendedor" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Carlos Mendes</h4>
                            <p class="testimonial-role">Vendedor há 1 ano</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Comecei vendendo seguros como complemento da minha renda, mas os resultados foram tão bons que hoje me dedico integralmente. O app de vendas e os materiais de marketing fazem toda a diferença no dia a dia."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/vendor-2.jpg" alt="Vendedor" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Ana Paula Silva</h4>
                            <p class="testimonial-role">Vendedora há 8 meses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"O que mais me impressiona é o suporte que recebemos. Sempre que tenho uma dúvida ou preciso de ajuda com uma venda mais complexa, a equipe está pronta para me auxiliar. Isso me dá confiança para vender qualquer produto."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/vendor-3.jpg" alt="Vendedor" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Roberto Almeida</h4>
                            <p class="testimonial-role">Vendedor há 1,5 anos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Registration Section -->
<section class="registration-section py-5" id="cadastro">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h2 class="section-title">Torne-se um Vendedor</h2>
                <p class="lead mb-4">Preencha o formulário ao lado para se cadastrar como vendedor e começar sua jornada de sucesso.</p>

                <div class="vendor-benefits mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="benefit-icon-small me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Treinamento Gratuito</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="benefit-icon-small me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Horários Flexíveis</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="benefit-icon-small me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Suporte Completo</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="benefit-icon-small me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Pagamento Semanal</h4>
                        </div>
                    </div>
                </div>

                <div class="vendor-requirements">
                    <h4 class="mb-3">Requisitos para ser vendedor:</h4>
                    <ul class="requirements-list">
                        <li><i class="fas fa-angle-right"></i> Ser maior de 18 anos</li>
                        <li><i class="fas fa-angle-right"></i> Ter ensino médio completo</li>
                        <li><i class="fas fa-angle-right"></i> Possuir smartphone ou computador com acesso à internet</li>
                        <li><i class="fas fa-angle-right"></i> Disponibilidade para treinamento inicial</li>
                        <li><i class="fas fa-angle-right"></i> Vontade de crescer e construir uma rede de vendas</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="registration-form-card">
                    <h3 class="mb-4 fw-bold">Cadastro de Vendedor</h3>
                    <form id="vendorForm">
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
                            <label for="city" class="form-label">Cidade/Estado</label>
                            <input type="text" class="form-control" id="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="form-label">Experiência em Vendas</label>
                            <select class="form-select" id="experience" required>
                                <option value="" selected disabled>Selecione uma opção</option>
                                <option value="nenhuma">Nenhuma experiência</option>
                                <option value="menos-1-ano">Menos de 1 ano</option>
                                <option value="1-3-anos">1 a 3 anos</option>
                                <option value="mais-3-anos">Mais de 3 anos</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="availability" class="form-label">Disponibilidade</label>
                            <select class="form-select" id="availability" required>
                                <option value="" selected disabled>Selecione uma opção</option>
                                <option value="integral">Tempo Integral</option>
                                <option value="parcial">Tempo Parcial</option>
                                <option value="fins-semana">Apenas fins de semana</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Por que deseja ser vendedor? (Opcional)</label>
                            <textarea class="form-control" id="message" rows="3"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">Concordo com os <a href="#">termos e condições</a> do programa de vendedores</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Cadastrar-me como Vendedor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
