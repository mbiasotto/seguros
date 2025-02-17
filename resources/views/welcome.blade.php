<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTTO - AI Automation Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
        }
        .hero-section {
            background: linear-gradient(135deg, #0062cc, #0099ff);
            color: white;
            padding: 100px 0;
        }
        .feature-box {
            padding: 30px;
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .feature-box:hover {
            transform: translateY(-10px);
        }
        .cta-section {
            background-color: #f8f9fa;
            padding: 80px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">OTTO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">Transforming Business Through AI Automation</h1>
                    <p class="lead mb-4">OTTO helps businesses leverage the power of artificial intelligence to automate processes, increase efficiency, and drive growth.</p>
                    <a href="#contact" class="btn btn-light btn-lg">Get Started</a>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="https://via.placeholder.com/600x400" alt="AI Automation" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" id="services">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Our AI Solutions</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box shadow-sm h-100 bg-white">
                        <h3 class="h5 mb-3">Process Automation</h3>
                        <p class="text-muted mb-0">Streamline your operations with intelligent automation solutions that learn and adapt.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box shadow-sm h-100 bg-white">
                        <h3 class="h5 mb-3">Smart Analytics</h3>
                        <p class="text-muted mb-0">Turn data into actionable insights with our advanced AI analytics platform.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box shadow-sm h-100 bg-white">
                        <h3 class="h5 mb-3">AI Integration</h3>
                        <p class="text-muted mb-0">Seamlessly integrate AI capabilities into your existing business systems.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section" id="contact">
        <div class="container text-center">
            <h2 class="mb-4" data-aos="fade-up">Ready to Transform Your Business?</h2>
            <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Join the AI revolution with OTTO</p>
            <button class="btn btn-primary btn-lg" data-aos="fade-up" data-aos-delay="200">Contact Us Today</button>
        </div>
    </section>

    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2023 OTTO. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>
