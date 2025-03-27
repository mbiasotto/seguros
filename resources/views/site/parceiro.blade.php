@extends('layouts.site')

@section('title', 'Programa de Parceiros | Câmara & Garutti - Multiplique seus ganhos')

@section('content')
<!-- Hero Section -->
<section class="hero-section parceiro-page">
    <div class="tear-effect"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-text" data-aos="fade-right">
                <h1 class="hero-title mb-3">Multiplique seus ganhos com nosso Programa de Parceiros</h1>
                <p class="hero-subtitle mb-4">Indique clientes e ganhe comissões recorrentes sem precisar vender</p>
                <div class="d-flex gap-3">
                    <a href="#cadastro" class="btn btn-light btn-lg fw-bold px-4 py-3 rounded-pill shadow-sm">Quero ser Parceiro</a>
                    <a href="#como-funciona" class="btn btn-outline-light btn-lg fw-bold px-4 py-3 rounded-pill">Como Funciona</a>
                </div>
            </div>
            <div class="col-lg-6 hero-image" data-aos="fade-left">
                <img src="/img/partner-hero.svg" alt="Programa de Parceiros" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section py-5" id="beneficios">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Por que se tornar um Parceiro?</h2>
            <p class="section-subtitle">Vantagens exclusivas para nossos parceiros</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="benefit-card h-100">
                    <div class="benefit-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="benefit-title">Comissões Recorrentes</h3>
                    <p class="benefit-description">Ganhe comissões não apenas na primeira contratação, mas em todas as renovações dos seus indicados.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="benefit-card h-100">
                    <div class="benefit-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="benefit-title">Sem Necessidade de Vender</h3>
                    <p class="benefit-description">Você apenas indica, nossa equipe cuida de todo o processo de venda e atendimento ao cliente.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="benefit-card h-100">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="benefit-title">Renda Extra Ilimitada</h3>
                    <p class="benefit-description">Não há limite para o número de indicações. Quanto mais você indicar, mais você ganha.</p>
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
            <p class="section-subtitle">Processo simples para começar a ganhar</p>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card text-center">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="step-title">Cadastre-se</h3>
                    <p class="step-description">Preencha o formulário de cadastro para se tornar um parceiro oficial.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card text-center">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h3 class="step-title">Indique Clientes</h3>
                    <p class="step-description">Compartilhe seu link personalizado ou indique diretamente pelo sistema.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card text-center">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="step-title">Nós Cuidamos da Venda</h3>
                    <p class="step-description">Nossa equipe entra em contato e cuida de todo o processo de venda.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="step-card text-center">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="step-title">Receba suas Comissões</h3>
                    <p class="step-description">Ganhe comissões na contratação e em todas as renovações futuras.</p>
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
            <p class="section-subtitle">Conheça nosso plano de comissionamento</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="commission-table-wrapper" data-aos="fade-up">
                    <table class="table commission-table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Comissão Inicial</th>
                                <th>Comissão Recorrente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Seguro Auto</td>
                                <td>15%</td>
                                <td>10%</td>
                            </tr>
                            <tr>
                                <td>Seguro Residencial</td>
                                <td>20%</td>
                                <td>15%</td>
                            </tr>
                            <tr>
                                <td>Seguro de Vida</td>
                                <td>25%</td>
                                <td>15%</td>
                            </tr>
                            <tr>
                                <td>Seguro Saúde</td>
                                <td>15%</td>
                                <td>10%</td>
                            </tr>
                            <tr>
                                <td>Financiamentos</td>
                                <td>1% do valor</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Consórcios</td>
                                <td>1% do valor</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5" id="depoimentos">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">O Que Nossos Parceiros Dizem</h2>
            <p class="section-subtitle">Experiências reais de quem já está ganhando com a gente</p>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Comecei como parceiro há 6 meses e já indiquei mais de 20 clientes. O processo é super simples e a equipe de suporte é excelente. Estou muito satisfeito com os resultados!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/partner-1.jpg" alt="Parceiro" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Marcos Oliveira</h4>
                            <p class="testimonial-role">Contador</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Como corretora de imóveis, ofereço seguros residenciais para meus clientes através da parceria. É uma renda extra significativa e meus clientes ficam muito satisfeitos com o atendimento."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/partner-2.jpg" alt="Parceiro" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Juliana Santos</h4>
                            <p class="testimonial-role">Corretora de Imóveis</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card h-100">
                    <div class="testimonial-content">
                        <p>"Sou advogado e indico seguros para meus clientes. O melhor é que não preciso me envolver no processo de venda, apenas faço a indicação e a equipe cuida do resto. As comissões recorrentes são um diferencial incrível."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/img/partner-3.jpg" alt="Parceiro" class="img-fluid rounded-circle">
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">Ricardo Mendes</h4>
                            <p class="testimonial-role">Advogado</p>
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
                <h2 class="section-title">Torne-se um Parceiro</h2>
                <p class="lead mb-4">Preencha o formulário ao lado para se cadastrar em nosso programa de parceiros e começar a ganhar comissões.</p>

                <div class="partner-benefits mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="benefit-icon-small me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Cadastro Gratuito</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="benefit-icon-small me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Sem Metas ou Obrigações</h4>
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
                            <h4 class="mb-0">Pagamento Pontual</h4>
                        </div>
                    </div>
                </div>

                <div class="partner-types">
                    <h4 class="mb-3">Quem pode ser parceiro?</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="partner-type-card">
                                <i class="fas fa-briefcase"></i>
                                <span>Contadores</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="partner-type-card">
                                <i class="fas fa-home"></i>
                                <span>Corretores</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="partner-type-card">
                                <i class="fas fa-balance-scale"></i>
                                <span>Advogados</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="partner-type-card">
                                <i class="fas fa-car"></i>
                                <span>Mecânicos</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="partner-type-card">
                                <i class="fas fa-store"></i>
                                <span>Lojistas</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="partner-type-card">
                                <i class="fas fa-user"></i>
                                <span>Autônomos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="registration-form-card">
                    <h3 class="mb-4 fw-bold">Cadastro de Parceiro</h3>
                    <form id="partnerForm">
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
                            <label for="profession" class="form-label">Profissão/Área de Atuação</label>
                            <input type="text" class="form-control" id="profession" required>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Cidade/Estado</label>
                            <input type="text" class="form-control" id="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="how_found" class="form-label">Como conheceu nosso programa?</label>
                            <select class="form-select" id="how_found" required>
                                <option value="" selected disabled>Selecione uma opção</option>
                                <option value="indicacao">Indicação</option>
                                <option value="redes-sociais">Redes Sociais</option>
                                <option value="google">Google</option>
                                <option value="email">E-mail Marketing</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensagem (Opcional)</label>
                            <textarea class="form-control" id="message" rows="3"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">Concordo com os <a href="#">termos e condições</a> do programa de parceiros</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Cadastrar-me como Parceiro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection