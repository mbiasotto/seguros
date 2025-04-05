<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link href="{{ asset('css/components/modal.css') }}" rel="stylesheet">
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
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            color: #333;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        p {
            font-size: 1.05rem;
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

        /* Hero Section Styles */
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
            font-size: 3.5rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
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

        .wave-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .discount-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--dark-green);
            color: white;
            padding: 15px;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: rotate(10deg);
        }

        .discount-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
        }

        .discount-text {
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Navbar Styles */
        .navbar {
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar-scrolled {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark-green);
        }

        .nav-link {
            font-weight: 500;
            color: var(--gray-800);
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-green);
        }

        .navbar-toggler {
            border: none;
            padding: 0;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Section Styles */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        /* Service Cards */
        .service-card, .benefit-card, .tool-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover, .benefit-card:hover, .tool-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .service-icon, .benefit-icon, .tool-icon {
            width: 70px;
            height: 70px;
            background-color: var(--light-green);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .service-title, .benefit-title, .tool-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--gray-800);
        }

        .service-features {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .service-features li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .service-features li i {
            color: var(--primary-green);
            margin-right: 10px;
        }

        /* Step Cards */
        .step-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }

        .step-number {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 40px;
            background-color: var(--primary-green);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            font-size: 1.2rem;
            z-index: 2;
        }

        .step-icon {
            font-size: 2.5rem;
            color: var(--primary-green);
            margin-bottom: 20px;
        }

        .step-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Testimonial Cards */
        .testimonial-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .testimonial-content {
            font-style: italic;
            margin-bottom: 20px;
            position: relative;
            padding: 0 15px;
        }

        .testimonial-content::before {
            content: '\201C';
            font-size: 4rem;
            position: absolute;
            left: -15px;
            top: -20px;
            color: var(--light-green);
            opacity: 0.3;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
            border: 3px solid var(--light-green);
        }

        .testimonial-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0;
        }

        .testimonial-role {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0;
        }

        /* Partner Logos */
        .partner-logo {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            transition: transform 0.3s ease;
        }

        .partner-logo:hover {
            transform: scale(1.05);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 8s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        .contact-form-card, .registration-form-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Commission Table */
        .commission-table-wrapper {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .commission-table {
            margin-bottom: 0;
        }

        .commission-table th {
            background-color: var(--primary-green);
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 15px;
        }

        .commission-table td {
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid var(--gray-200);
        }

        .commission-table tr:last-child td {
            border-bottom: none;
        }

        /* Partner Types */
        .partner-type-card {
            background-color: var(--gray-100);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .partner-type-card:hover {
            background-color: var(--primary-green);
            color: white;
        }

        .partner-type-card i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            display: block;
        }

        /* Vendor Requirements */
        .requirements-list {
            list-style: none;
            padding: 0;
        }

        .requirements-list li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .requirements-list li i {
            color: var(--primary-green);
            margin-right: 10px;
        }

        /* Footer */
        .footer {
            background-color: var(--gray-800);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-contact {
            margin-bottom: 20px;
        }

        .footer-contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .footer-contact-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
        }

        .footer-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary-green);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-green);
        }

        .footer-social {
            display: flex;
            gap: 15px;
        }

        .footer-social-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }

        .footer-social-icon:hover {
            background-color: var(--primary-green);
            transform: translateY(-5px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            font-size: 0.9rem;
            color: #aaa;
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        /* Estilos específicos para páginas */
        .parceiro-page {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
        }

        .parceiro-page body {
            font-family: 'DM Sans', sans-serif;
        }

        .parceiro-page h1, .parceiro-page h2, .parceiro-page h3, .parceiro-page h4, .parceiro-page h5, .parceiro-page h6, .parceiro-page .navbar-brand {
            font-family: 'Outfit', sans-serif;
        }

        .vendedor-page {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        }

        .vendedor-page body {
            font-family: 'DM Sans', sans-serif;
        }

        .vendedor-page h1, .vendedor-page h2, .vendedor-page h3, .vendedor-page h4, .vendedor-page h5, .vendedor-page h6, .vendedor-page .navbar-brand {
            font-family: 'Outfit', sans-serif;
        }

        @media (max-width: 767.98px) {
            .hero-section {
                padding: 80px 0;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-image {
                margin-top: 40px;
            }

            .discount-badge {
                width: 80px;
                height: 80px;
                padding: 10px;
            }

            .discount-value {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="/">Câmara & Garutti</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#servicos">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#como-funciona">Como Funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#depoimentos">Depoimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/parceiro">Seja Parceiro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vendedor">Seja Vendedor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white px-4 ms-2" href="/#contato">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="footer-logo">Câmara & Garutti</div>
                    <p class="mb-4">Oferecemos as melhores soluções em seguros e financiamentos com condições exclusivas para nossos clientes.</p>
                    <div class="footer-contact">
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>Av. Paulista, 1000 - Bela Vista<br>São Paulo - SP, 01310-100</div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>(11) 3456-7890</div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>contato@camaraegarutti.com.br</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-5 mb-md-0">
                    <h4 class="footer-title">Links Rápidos</h4>
                    <ul class="footer-links">
                        <li><a href="/">Home</a></li>
                        <li><a href="/#servicos">Serviços</a></li>
                        <li><a href="/#como-funciona">Como Funciona</a></li>
                        <li><a href="/#depoimentos">Depoimentos</a></li>
                        <li><a href="/#contato">Contato</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-5 mb-md-0">
                    <h4 class="footer-title">Serviços</h4>
                    <ul class="footer-links">
                        <li><a href="/#servicos">Seguro Auto</a></li>
                        <li><a href="/#servicos">Seguro Residencial</a></li>
                        <li><a href="/#servicos">Seguro Saúde</a></li>
                        <li><a href="/#servicos">Seguro de Vida</a></li>
                        <li><a href="/#servicos">Financiamentos</a></li>
                        <li><a href="/#servicos">Consórcios</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="footer-title">Oportunidades</h4>
                    <ul class="footer-links">
                        <li><a href="/parceiro">Programa de Parceiros</a></li>
                        <li><a href="/vendedor">Seja um Vendedor</a></li>
                    </ul>
                    <h4 class="footer-title mt-4">Redes Sociais</h4>
                    <div class="footer-social">
                        <a href="#" class="footer-social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="footer-social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="footer-social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="footer-social-icon">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Câmara & Garutti. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Form submission
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Obrigado pelo seu contato! Em breve nossa equipe entrará em contato.');
                    contactForm.reset();
                });
            }

            const partnerForm = document.getElementById('partnerForm');
            if (partnerForm) {
                partnerForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Obrigado pelo seu cadastro! Em breve nossa equipe entrará em contato para dar continuidade ao seu processo de parceria.');
                    partnerForm.reset();
                });
            }

            const vendorForm = document.getElementById('vendorForm');
            if (vendorForm) {
                vendorForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Obrigado pelo seu cadastro! Em breve nossa equipe entrará em contato para dar continuidade ao seu processo de vendedor.');
                    vendorForm.reset();
                });
            }
        });
    </script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Form submission
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Formulário enviado com sucesso! Em breve entraremos em contato.');
                    contactForm.reset();
                });
            }

            const partnerForm = document.getElementById('partnerForm');
            if (partnerForm) {
                partnerForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Cadastro de parceiro enviado com sucesso! Em breve entraremos em contato.');
                    partnerForm.reset();
                });
            }

            const vendorForm = document.getElementById('vendorForm');
            if (vendorForm) {
                vendorForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Cadastro de vendedor enviado com sucesso! Em breve entraremos em contato.');
                    vendorForm.reset();
                });
            }
        });
    </script>
    <!-- Scripts -->
    <script src="{{ asset('js/site.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
</body>
</html>
