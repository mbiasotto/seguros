<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câmara & Garutti - Seguros e Financiamentos com até 30% de Desconto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts - Novas fontes mais elegantes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #4CAF50;
            --dark-green: #006400;
            --light-green: #8BC34A;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-800: #343a40;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            color: #333;
            line-height: 1.7;
            font-weight: 400;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        p {
            font-size: 1.05rem;
        }

        .lead {
            font-weight: 400;
            font-size: 1.2rem;
        }

        .bg-primary-green {
            background-color: var(--primary-green);
        }

        .bg-dark-green {
            background-color: var(--dark-green);
        }

        .text-dark-green {
            color: var(--dark-green);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            position: relative;
            overflow: hidden;
            padding: 100px 0;
        }

        .hero-text {
            color: white;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4.2rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .hero-image {
            position: relative;
            z-index: 2;
        }

        .tear-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 C75,70 25,100 0,70 Z" fill="%238BC34A" /></svg>');
            background-size: cover;
            z-index: 1;
        }

        .discount-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--dark-green);
            color: white;
            padding: 15px;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            transform: rotate(15deg);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 3;
        }

        /* Redesigned Service Cards */
        .services-section {
            padding: 100px 0;
            background-color: var(--gray-100);
        }

        .services-section h2 {
            font-size: 2.8rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .services-section h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--primary-green);
        }

        .service-card {
            background-color: white;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            position: relative;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .service-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0;
            background-color: var(--primary-green);
            transition: height 0.4s ease;
        }

        .service-card:hover:before {
            height: 100%;
        }

        .service-card .card-body {
            padding: 2rem;
            z-index: 1;
        }

        .service-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--primary-green);
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            background-color: var(--primary-green);
            color: white;
            transform: scale(1.1);
        }

        .service-card h3 {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--gray-800);
        }

        .service-card p {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .service-card .btn {
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            border-radius: 30px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .service-card .btn-outline-success {
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .service-card .btn-outline-success:hover {
            background-color: var(--primary-green);
            color: white;
        }

        /* Parceiros Section */
        .partners-section {
            padding: 100px 0;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            position: relative;
            overflow: hidden;
        }

        .partners-section:before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background-color: rgba(76, 175, 80, 0.05);
            border-radius: 50%;
            transform: translate(150px, -150px);
        }

        .partners-section:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200px;
            height: 200px;
            background-color: rgba(76, 175, 80, 0.05);
            border-radius: 50%;
            transform: translate(-100px, 100px);
        }

        .partners-section h2 {
            font-size: 2.8rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .partners-section h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--primary-green);
        }

        .partner-card {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .partner-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .partner-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 2.5rem;
            color: var(--primary-green);
        }

        .partner-card h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: var(--gray-800);
        }

        .partner-card p {
            margin-bottom: 25px;
            color: #6c757d;
        }

        .partner-feature {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .partner-feature i {
            color: var(--primary-green);
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .partner-cta {
            margin-top: 30px;
        }

        .commission-box {
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            border-left: 4px solid var(--primary-green);
        }

        .commission-box h4 {
            color: var(--dark-green);
            margin-bottom: 15px;
            font-size: 1.4rem;
        }

        .commission-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            padding: 80px 0;
            position: relative;
        }

        .cta-form {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }

        .cta-form h3 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .cta-form h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--primary-green);
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .benefits-section {
            background-color: #f9f9f9;
            padding: 80px 0;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .benefit-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: var(--primary-green);
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .benefit-item:hover .benefit-icon {
            background-color: var(--primary-green);
            color: white;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            font-size: 3rem;
            font-weight: 800;
            color: white;
            letter-spacing: 2px;
            padding: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .btn-cta {
            background-color: var(--dark-green);
            color: white;
            padding: 14px 32px;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.5px;
        }

        .btn-cta:hover {
            background-color: var(--primary-green);
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .testimonial-card {
            background-color: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            position: relative;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .testimonial-card:before {
            content: '\201C';
            font-family: Georgia, serif;
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 5rem;
            color: rgba(76, 175, 80, 0.1);
            line-height: 1;
        }

        .testimonial-rating {
            color: #FFD700;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .testimonial-author strong {
            color: var(--gray-800);
            font-weight: 600;
        }

        footer {
            background-color: var(--dark-green);
            color: white;
            padding: 80px 0 20px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .social-icons a:hover {
            transform: translateY(-5px);
        }

        .counter-box {
            text-align: center;
            padding: 30px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .counter-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .counter-number {
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-green);
            margin-bottom: 15px;
            font-family: 'Playfair Display', serif;
        }

        .counter-text {
            font-size: 1.1rem;
            color: var(--gray-800);
            font-weight: 500;
        }

        .qr-code-section {
            position: relative;
            overflow: hidden;
        }

        .qr-code-container {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        .arrow-animation {
            animation: arrowPulse 2s infinite;
        }

        @keyframes arrowPulse {
            0% { transform: translateX(0); }
            50% { transform: translateX(10px); }
            100% { transform: translateX(0); }
        }

        /* Animação de entrada para o título principal */
        .animate-title {
            animation: fadeInUp 1.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Navbar Styling */
        .navbar {
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover:after {
            width: 80%;
        }

        .navbar .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Form Styling */
        .form-control, .form-select {
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
            border-color: var(--primary-green);
        }

        /* Section Titles */
        .section-title {
            position: relative;
            margin-bottom: 3rem;
            font-weight: 700;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-green);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.5rem;
            }

            .discount-badge {
                width: 80px;
                height: 80px;
                font-size: 0.8rem;
            }

            .vertical-text {
                font-size: 2rem;
            }

            .service-card .card-body {
                padding: 1.5rem;
            }

            .service-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .cta-form {
                padding: 25px;
            }

            .partner-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-green sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Prancheta%201-f9YwBot3lw7qHyEzeokuVE3dPOSDLe.png" alt="Câmara & Garutti Logo" height="40" class="me-2">
                <span>Câmara & Garutti</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#seguros">Seguros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#financiamentos">Financiamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#beneficios">Benefícios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#parceiros">Seja Parceiro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contato">Contato</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-light" href="#contato">Solicitar Cotação</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="tear-effect"></div>
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-text" data-aos="fade-right">
                    <h1 class="hero-title animate-title">Segura essa!</h1>
                    <h2 class="hero-subtitle mb-4">MUITOS BENEFÍCIOS PARA VOCÊ</h2>
                    <p class="lead mb-4">Descontos, Super-Brindes, Promoções.</p>
                    <a href="#contato" class="btn btn-cta">Quero Aproveitar</a>
                </div>
                <div class="col-lg-6 hero-image" data-aos="fade-left">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Prancheta%201-f9YwBot3lw7qHyEzeokuVE3dPOSDLe.png" alt="Promoção Câmara & Garutti" class="img-fluid">
                </div>
            </div>
            <div class="discount-badge" data-aos="zoom-in" data-aos-delay="300">
                <span>ATÉ</span>
                <span style="font-size: 2rem;">30%</span>
                <span>DESCONTO</span>
            </div>
        </div>
    </section>

    <!-- Serviços Section - Redesenhada -->
    <section class="services-section" id="seguros">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title display-4 fw-bold text-dark-green" data-aos="fade-up">Nossos Seguros</h2>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100">Soluções completas de proteção para você, sua família e seu patrimônio</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <h3>Residencial</h3>
                            <p>Proteja seu lar contra imprevistos com nosso seguro residencial completo. Cobertura para incêndio, roubo, danos elétricos e muito mais.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar Cotação</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3>Empresarial</h3>
                            <p>Soluções completas para proteger seu negócio e garantir a continuidade das operações. Coberturas personalizadas para cada tipo de empresa.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar Cotação</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <h3>Veículos</h3>
                            <p>Proteção completa para seu veículo com as melhores coberturas do mercado. Assistência 24h, carro reserva e muito mais.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar Cotação</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-plane"></i>
                            </div>
                            <h3>Viagem</h3>
                            <p>Viaje com tranquilidade sabendo que está protegido em qualquer lugar do mundo. Cobertura médica, extravio de bagagem e muito mais.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar Cotação</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <h3>Vida</h3>
                            <p>Garanta a segurança financeira da sua família com nosso seguro de vida. Coberturas personalizadas para suas necessidades.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar Cotação</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <h3>Máquinas</h3>
                            <p>Proteja seus equipamentos e máquinas contra danos e prejuízos inesperados. Cobertura para quebra, roubo e muito mais.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar Cotação</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Financiamentos Section - Redesenhada -->
    <section class="services-section bg-white" id="financiamentos">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title display-4 fw-bold text-dark-green" data-aos="fade-up">Financiamentos</h2>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100">As melhores condições para realizar seus sonhos com taxas competitivas</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <h3>Caminhão</h3>
                            <p>Financiamento para caminhões novos e usados com as melhores taxas do mercado e prazos estendidos.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-car-side"></i>
                            </div>
                            <h3>Automóvel</h3>
                            <p>Realize o sonho do carro novo com nossas condições especiais de financiamento e aprovação rápida para todos os modelos.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <h3>Moto</h3>
                            <p>Financiamento para motos com parcelas que cabem no seu bolso e condições especiais para todos os modelos.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h3>Cartão de Crédito</h3>
                            <p>Cartão de crédito com vantagens exclusivas, benefícios especiais e programa de pontos diferenciado.</p>
                            <a href="#contato" class="btn btn-outline-success">Solicitar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 mx-auto" data-aos="fade-up">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="service-icon">
                                <i class="fas fa-medkit"></i>
                            </div>
                            <h3>Plano de Saúde</h3>
                            <p>Cuide da sua saúde e da sua família com nossos planos de saúde com cobertura completa e rede credenciada de qualidade.</p>
                            <a href="#contato" class="btn btn-outline-success">Saiba Mais</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nova Seção de Parceiros -->
    <section class="partners-section" id="parceiros">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title display-4 fw-bold text-dark-green" data-aos="fade-up">Programa de Parceiros</h2>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100">Torne-se um parceiro da Câmara & Garutti e ganhe comissões por cada cliente indicado</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="partner-card">
                        <div class="partner-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Como Funciona</h3>
                        <p>Nosso programa de parceria é simples e lucrativo. Você recebe um QR code exclusivo para colocar em seu estabelecimento, e ganha comissões por cada cliente que contratar nossos serviços através da sua indicação.</p>

                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Receba um QR code personalizado para seu estabelecimento</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Sistema de rastreamento identifica todas as suas indicações</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Ganhe comissões por cada venda realizada</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Receba relatórios mensais de desempenho</span>
                        </div>

                        <div class="commission-box">
                            <h4>Comissões Atrativas</h4>
                            <div class="commission-value">5% a 15%</div>
                            <p>Dependendo do produto contratado, você pode ganhar entre 5% e 15% de comissão sobre cada venda realizada através da sua indicação.</p>
                        </div>

                        <div class="partner-cta">
                            <a href="#contato" class="btn btn-cta">Quero Ser Parceiro</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="partner-card">
                        <div class="partner-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <h3>Benefícios para Parceiros</h3>
                        <p>Além das comissões, nossos parceiros têm acesso a diversos benefícios exclusivos:</p>

                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Renda extra sem investimento inicial</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Materiais de divulgação gratuitos</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Treinamento e suporte contínuo</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Descontos exclusivos em nossos produtos</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Programa de bonificação por metas atingidas</span>
                        </div>
                        <div class="partner-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Acesso a eventos e treinamentos exclusivos</span>
                        </div>

                        <div class="mt-4">
                            <h4>Quem pode ser parceiro?</h4>
                            <p>Nosso programa é ideal para:</p>
                            <ul>
                                <li>Comércios locais</li>
                                <li>Profissionais liberais</li>
                                <li>Escritórios e consultórios</li>
                                <li>Academias e salões de beleza</li>
                                <li>Restaurantes e lanchonetes</li>
                                <li>E muito mais!</li>
                            </ul>
                        </div>

                        <div class="text-center mt-4">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://www.camaraegarutti.com.br/parceiros" alt="QR Code Parceiros" class="img-fluid mb-3">
                            <p>Escaneie o QR code para mais informações</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefícios Section -->
    <section class="benefits-section" id="beneficios">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title display-4 fw-bold text-dark-green" data-aos="fade-up">Benefícios Exclusivos</h2>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100">Vantagens que só a Câmara & Garutti oferece para você</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div>
                            <h4>Descontos de até 30%</h4>
                            <p>Economize com nossos descontos exclusivos em todos os produtos.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div>
                            <h4>Super-Brindes</h4>
                            <p>Ganhe brindes especiais ao contratar nossos serviços.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div>
                            <h4>Promoções Exclusivas</h4>
                            <p>Acesso a promoções especiais durante todo o ano.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4>Atendimento Personalizado</h4>
                            <p>Consultores especializados para atender suas necessidades.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div>
                            <h4>Processo Simplificado</h4>
                            <p>Contratação rápida e sem burocracia.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h4>Segurança Garantida</h4>
                            <p>Trabalho com as melhores seguradoras do mercado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Números Section -->
    <section class="py-5 bg-primary-green text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-3" data-aos="fade-up">
                    <div class="counter-box">
                        <div class="counter-number" data-count="15000">0</div>
                        <div class="counter-text">Clientes Satisfeitos</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="counter-box">
                        <div class="counter-number" data-count="20">0</div>
                        <div class="counter-text">Anos de Experiência</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="counter-box">
                        <div class="counter-number" data-count="30">0</div>
                        <div class="counter-text">Parceiros</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="counter-box">
                        <div class="counter-number" data-count="98">0</div>
                        <div class="counter-text">% de Aprovação</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Depoimentos Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title display-4 fw-bold text-dark-green" data-aos="fade-up">O que dizem nossos clientes</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Contratei o seguro residencial e fiquei impressionado com o atendimento e as condições. Recomendo a todos!"</p>
                        <div class="testimonial-author">
                            <strong>Carlos Silva</strong> - Cliente desde 2019
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"O financiamento do meu carro foi aprovado em tempo recorde e com uma taxa excelente. Estou muito satisfeita!"</p>
                        <div class="testimonial-author">
                            <strong>Ana Oliveira</strong> - Cliente desde 2021
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text">"O plano de saúde que contratei tem uma ótima cobertura e o preço cabe no meu orçamento. Excelente empresa!"</p>
                        <div class="testimonial-author">
                            <strong>Marcos Santos</strong> - Cliente desde 2020
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- QR Code Section -->
    <section class="py-5 qr-code-section bg-dark-green">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 d-none d-lg-block" data-aos="fade-right">
                    <div class="vertical-text">
                        DESCONTOS IMPERDÍVEIS
                    </div>
                </div>
                <div class="col-lg-6" data-aos="zoom-in">
                    <div class="qr-code-container text-center">
                        <h3 class="mb-4 text-dark-green">Para saber mais, aponte a câmera do seu celular no código ao lado</h3>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="me-4">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://www.camaraegarutti.com.br" alt="QR Code" class="img-fluid">
                            </div>
                            <div class="arrow-animation">
                                <i class="fas fa-arrow-right fa-3x text-success"></i>
                            </div>
                        </div>
                        <p class="mt-3">Ou acesse <a href="https://www.camaraegarutti.com.br" class="text-success fw-bold">www.camaraegarutti.com.br</a></p>
                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-block" data-aos="fade-left">
                    <div class="vertical-text">
                        DESCONTOS IMPERDÍVEIS
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
                            <h4 class="mb-0">Descontos Exclusivos</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="cta-form">
                        <h3 class="text-center mb-4 text-dark-green">Solicite uma Cotação</h3>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Nome Completo" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="E-mail" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" placeholder="Telefone" required>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" required>
                                    <option value="" selected disabled>Selecione o Serviço</option>
                                    <option value="seguro_residencial">Seguro Residencial</option>
                                    <option value="seguro_empresarial">Seguro Empresarial</option>
                                    <option value="seguro_veiculos">Seguro Veículos</option>
                                    <option value="seguro_viagem">Seguro Viagem</option>
                                    <option value="seguro_vida">Seguro Vida</option>
                                    <option value="seguro_maquinas">Seguro Máquinas</option>
                                    <option value="financiamento_caminhao">Financiamento Caminhão</option>
                                    <option value="financiamento_automovel">Financiamento Automóvel</option>
                                    <option value="financiamento_moto">Financiamento Moto</option>
                                    <option value="cartao_credito">Cartão de Crédito</option>
                                    <option value="plano_saude">Plano de Saúde</option>
                                    <option value="parceria">Quero ser Parceiro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" placeholder="Mensagem (opcional)"></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-cta">Solicitar Cotação</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Prancheta%201-f9YwBot3lw7qHyEzeokuVE3dPOSDLe.png" alt="Câmara & Garutti Logo" height="60" class="mb-3">
                    <p>A Câmara & Garutti é uma corretora de seguros com mais de 20 anos de experiência no mercado, oferecendo as melhores soluções em seguros e financiamentos.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-4">Seguros</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#">Residencial</a></li>
                        <li class="mb-2"><a href="#">Empresarial</a></li>
                        <li class="mb-2"><a href="#">Veículos</a></li>
                        <li class="mb-2"><a href="#">Viagem</a></li>
                        <li class="mb-2"><a href="#">Vida</a></li>
                        <li><a href="#">Máquinas</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-4">Financiamentos</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#">Caminhão</a></li>
                        <li class="mb-2"><a href="#">Automóvel</a></li>
                        <li class="mb-2"><a href="#">Moto</a></li>
                        <li class="mb-2"><a href="#">Cartão de Crédito</a></li>
                        <li><a href="#">Plano de Saúde</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="mb-4">Contato</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Av. Principal, 1234, Centro</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (11) 1234-5678</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> contato@camaraegarutti.com.br</li>
                        <li><i class="fas fa-clock me-2"></i> Seg-Sex: 9h às 18h</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2023 Câmara & Garutti. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Desenvolvido com <i class="fas fa-heart text-danger"></i> por Vercel</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script>
        // Inicializar AOS Animation
        AOS.init({
            duration: 800,
            once: true
        });

        // Contador de números
        const counterElements = document.querySelectorAll('.counter-number');

        const startCounters = () => {
            counterElements.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000; // 2 segundos
                const step = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
            });
        };

        // Iniciar contadores quando estiverem visíveis
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startCounters();
                    observer.disconnect();
                }
            });
        });

        if (counterElements.length > 0) {
            observer.observe(counterElements[0]);
        }

        // Smooth scroll para links de navegação
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>

