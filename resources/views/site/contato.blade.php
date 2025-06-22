@extends('layouts.site')

@section('title', 'Contato - Multiplic.cc')

@section('content')
    <!-- Header Section -->
    <section class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Entre em Contato</h1>
                    <p class="lead">Estamos aqui para ajudar você. Fale conosco!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Formulário de Contato -->
                <div class="col-lg-8 mb-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="fw-bold mb-4">Envie sua Mensagem</h3>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('site.contato.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Assunto <span class="text-danger">*</span></label>
                                    <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                                        <option value="">Selecione um assunto</option>
                                        <option value="Solicitação de Cartão" {{ old('subject') == 'Solicitação de Cartão' ? 'selected' : '' }}>Solicitação de Cartão</option>
                                        <option value="Dúvidas sobre o Produto" {{ old('subject') == 'Dúvidas sobre o Produto' ? 'selected' : '' }}>Dúvidas sobre o Produto</option>
                                        <option value="Problemas Técnicos" {{ old('subject') == 'Problemas Técnicos' ? 'selected' : '' }}>Problemas Técnicos</option>
                                        <option value="Reclamação" {{ old('subject') == 'Reclamação' ? 'selected' : '' }}>Reclamação</option>
                                        <option value="Sugestão" {{ old('subject') == 'Sugestão' ? 'selected' : '' }}>Sugestão</option>
                                        <option value="Parceria Comercial" {{ old('subject') == 'Parceria Comercial' ? 'selected' : '' }}>Parceria Comercial</option>
                                        <option value="Outros" {{ old('subject') == 'Outros' ? 'selected' : '' }}>Outros</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Mensagem <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                              id="message" name="message" rows="5" required
                                              placeholder="Descreva sua dúvida ou solicitação...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-warning btn-lg fw-bold text-dark px-4">
                                        <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Informações de Contato -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Informações de Contato</h4>

                            <div class="d-flex align-items-center mb-3">
                                <div class="contact-icon bg-warning rounded-circle me-3">
                                    <i class="fas fa-envelope text-dark"></i>
                                </div>
                                <div>
                                    <strong>E-mail</strong><br>
                                    <a href="mailto:contato@multiplic.cc" class="text-decoration-none">contato@multiplic.cc</a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="contact-icon bg-warning rounded-circle me-3">
                                    <i class="fab fa-whatsapp text-dark"></i>
                                </div>
                                <div>
                                    <strong>WhatsApp</strong><br>
                                    <a href="https://wa.me/5511999999999" class="text-decoration-none" target="_blank">(11) 99999-9999</a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="contact-icon bg-warning rounded-circle me-3">
                                    <i class="fas fa-phone text-dark"></i>
                                </div>
                                <div>
                                    <strong>Telefone</strong><br>
                                    <a href="tel:+551133333333" class="text-decoration-none">(11) 3333-3333</a>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="contact-icon bg-warning rounded-circle me-3">
                                    <i class="fas fa-map-marker-alt text-dark"></i>
                                </div>
                                <div>
                                    <strong>Endereço</strong><br>
                                    <span class="text-muted">
                                        Av. Paulista, 1000<br>
                                        Bela Vista - São Paulo/SP<br>
                                        CEP: 01310-100
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">Horário de Atendimento</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Segunda a Sexta:</span>
                                <span class="fw-bold">8h às 18h</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sábado:</span>
                                <span class="fw-bold">8h às 14h</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Domingo:</span>
                                <span class="text-muted">Fechado</span>
                            </div>
                            <hr>
                            <div class="text-center">
                                <small class="text-success">
                                    <i class="fab fa-whatsapp me-1"></i>
                                    WhatsApp disponível 24h
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Rápido -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="fw-bold mb-4 text-center">Perguntas Frequentes</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold text-warning">Como solicitar o cartão?</h5>
                                    <p class="mb-0">Acesse nossa <a href="{{ route('site.cadastro') }}" class="text-warning">página de cadastro</a> e preencha seus dados. A aprovação é rápida!</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold text-warning">O cartão tem anuidade?</h5>
                                    <p class="mb-0">Não! O cartão Multiplic.cc é totalmente gratuito, sem taxa de anuidade ou manutenção.</p>
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
        .contact-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
    </style>
@endsection
