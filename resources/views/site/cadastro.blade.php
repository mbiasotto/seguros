<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Multiplic.cc</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>
<body class="cadastro-page">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('site.index') }}">Multiplic.cc</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}#beneficios">Benefícios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}#rede">Rede Credenciada</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}#como-funciona">Como Funciona</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-warning fw-bold text-dark px-4" href="#">Área do Cliente</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cadastro Section -->
    <div class="cadastro-page pt-0 mt-0">
        <div class="row g-0 min-vh-100">
            <!-- Lado Esquerdo - Imagem -->
            <div class="col-lg-6 d-none d-lg-flex cadastro-left">
                <div class="cadastro-bg"></div>
                <div class="cadastro-content p-5 d-flex flex-column justify-content-center">
                    <div class="text-white mb-5">
                        <h2 class="display-6 fw-bold mb-3">Multiplic.cc</h2>
                        <p class="fs-5 text-light">O cartão pré-pago consignado que liberta sua vida financeira</p>
                    </div>

                    <!-- Cartão 3D -->
                    <div class="credit-card-3d mb-5">
                        <div class="credit-card">
                            <div class="card-shine"></div>
                            <div class="card-top-line"></div>
                            <div class="card-content">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div class="text-white fw-bold fs-5">Multiplic</div>
                                    <i class="fas fa-credit-card text-warning fs-4"></i>
                                </div>
                                <div class="text-white fs-5 font-monospace mb-3">•••• •••• •••• 1234</div>
                                <div class="d-flex justify-content-between text-white small">
                                    <div>
                                        <div class="text-muted" style="font-size: 0.7rem;">VÁLIDO ATÉ</div>
                                        <div>12/28</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="text-muted" style="font-size: 0.7rem;">TITULAR</div>
                                        <div>SEU NOME</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefícios -->
                    <div class="benefits-list">
                        <div class="d-flex align-items-center gap-3 text-white mb-3">
                            <div class="benefit-dot bg-warning rounded-circle"></div>
                            <span>Mesmo negativado, você é aceito</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 text-white mb-3">
                            <div class="benefit-dot bg-warning rounded-circle"></div>
                            <span>Sem anuidade para sempre</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 text-white mb-3">
                            <div class="benefit-dot bg-warning rounded-circle"></div>
                            <span>Débito direto na conta de luz</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div class="benefit-dot bg-warning rounded-circle"></div>
                            <span>Mais de 1.000 estabelecimentos</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lado Direito - Formulário -->
            <div class="col-lg-6 cadastro-right">
                <div class="p-4 p-lg-5">
                    <!-- Progress Bar -->
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="progress-dot active me-2"></div>
                                <span class="small fw-medium">Preencha seus dados</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="progress-dot me-2" id="step2Dot"></div>
                                <span class="small text-muted" id="step2Text">Finalize</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-warning" id="progressBar" style="width: 50%"></div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h1 class="display-6 fw-bold text-dark mb-2" id="formTitle">Abra sua conta</h1>
                        <p class="text-muted fs-6" id="formSubtitle">Começa aqui, leva poucos minutos</p>
                    </div>

                    <!-- Exibir erros de validação -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulário -->
                    <form id="cadastroForm" action="{{ route('site.cadastro.store') }}" method="POST">
                        @csrf

                                                <!-- Step 1 -->
                        <div id="step1" class="form-step">
                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    Nome Completo <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Digite seu nome completo" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    E-mail <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Digite seu melhor e-mail" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        CPF <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" placeholder="Digite seu CPF" required>
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        Telefone/WhatsApp <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Digite seu número" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div id="step2" class="form-step d-none">
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-medium">
                                        CEP <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep') }}" placeholder="00000-000" required>
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-medium">
                                        Endereço <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="Rua, Avenida..." required>
                                                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-medium">
                                        Número <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('number') is-invalid @enderror" name="number" value="{{ old('number') }}" placeholder="123" required>
                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-medium">Complemento</label>
                                    <input type="text" class="form-control form-control-lg @error('complement') is-invalid @enderror" name="complement" value="{{ old('complement') }}" placeholder="Apto, Casa...">
                                    @error('complement')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-medium">
                                        Bairro <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('neighborhood') is-invalid @enderror" name="neighborhood" value="{{ old('neighborhood') }}" placeholder="Seu bairro" required>
                                    @error('neighborhood')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        Cidade <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" placeholder="Sua cidade" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        Estado <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg @error('state') is-invalid @enderror" name="state" required>
                                        <option value="">Selecione o estado</option>
                                        <option value="AC" {{ old('estado') == 'AC' ? 'selected' : '' }}>AC</option>
                                        <option value="AL" {{ old('estado') == 'AL' ? 'selected' : '' }}>AL</option>
                                        <option value="AP" {{ old('estado') == 'AP' ? 'selected' : '' }}>AP</option>
                                        <option value="AM" {{ old('estado') == 'AM' ? 'selected' : '' }}>AM</option>
                                        <option value="BA" {{ old('estado') == 'BA' ? 'selected' : '' }}>BA</option>
                                        <option value="CE" {{ old('estado') == 'CE' ? 'selected' : '' }}>CE</option>
                                        <option value="DF" {{ old('estado') == 'DF' ? 'selected' : '' }}>DF</option>
                                        <option value="ES" {{ old('estado') == 'ES' ? 'selected' : '' }}>ES</option>
                                        <option value="GO" {{ old('estado') == 'GO' ? 'selected' : '' }}>GO</option>
                                        <option value="MA" {{ old('estado') == 'MA' ? 'selected' : '' }}>MA</option>
                                        <option value="MT" {{ old('estado') == 'MT' ? 'selected' : '' }}>MT</option>
                                        <option value="MS" {{ old('estado') == 'MS' ? 'selected' : '' }}>MS</option>
                                        <option value="MG" {{ old('estado') == 'MG' ? 'selected' : '' }}>MG</option>
                                        <option value="PA" {{ old('estado') == 'PA' ? 'selected' : '' }}>PA</option>
                                        <option value="PB" {{ old('estado') == 'PB' ? 'selected' : '' }}>PB</option>
                                        <option value="PR" {{ old('estado') == 'PR' ? 'selected' : '' }}>PR</option>
                                        <option value="PE" {{ old('estado') == 'PE' ? 'selected' : '' }}>PE</option>
                                        <option value="PI" {{ old('estado') == 'PI' ? 'selected' : '' }}>PI</option>
                                        <option value="RJ" {{ old('estado') == 'RJ' ? 'selected' : '' }}>RJ</option>
                                        <option value="RN" {{ old('estado') == 'RN' ? 'selected' : '' }}>RN</option>
                                        <option value="RS" {{ old('estado') == 'RS' ? 'selected' : '' }}>RS</option>
                                        <option value="RO" {{ old('estado') == 'RO' ? 'selected' : '' }}>RO</option>
                                        <option value="RR" {{ old('estado') == 'RR' ? 'selected' : '' }}>RR</option>
                                        <option value="SC" {{ old('estado') == 'SC' ? 'selected' : '' }}>SC</option>
                                        <option value="SP" {{ old('estado') == 'SP' ? 'selected' : '' }}>SP</option>
                                        <option value="SE" {{ old('estado') == 'SE' ? 'selected' : '' }}>SE</option>
                                        <option value="TO" {{ old('estado') == 'TO' ? 'selected' : '' }}>TO</option>
                                    </select>
                                                                        @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    Código CPFL <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg @error('cpflCode') is-invalid @enderror" name="cpflCode" value="{{ old('cpflCode') }}" placeholder="Digite o código da sua conta CPFL" required>
                                <div class="form-text">Encontre na sua conta de luz CPFL</div>
                                @error('cpflCode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    Senha <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Ex: 394726" required id="passwordInput">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="passwordIcon"></i>
                                    </button>
                                </div>
                                <div class="form-text">Use 6 a 8 dígitos, sem números repetidos ou em sequência</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="bg-light p-4 rounded mb-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('acceptTerms') is-invalid @enderror" type="checkbox" name="acceptTerms" id="acceptTerms" {{ old('acceptTerms') ? 'checked' : '' }} required>
                                    <label class="form-check-label small" for="acceptTerms">
                                        Ao continuar, você autoriza a consulta e o registro dos seus dados no sistema de informações
                                        de crédito (SCR) do banco central e também está de acordo com a
                                        <a href="#" class="text-warning">política de privacidade</a> do Multiplic.cc.
                                    </label>
                                    @error('acceptTerms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex gap-3 pt-4">
                            <button type="button" class="btn btn-outline-secondary btn-lg flex-fill d-none" id="backBtn">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </button>
                            <button type="button" class="btn btn-warning btn-lg fw-bold text-dark flex-fill" id="nextBtn">
                                Continuar <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <h4 class="fw-bold text-warning mb-3">Multiplic.cc</h4>
                    <p class="text-light opacity-75">O cartão pré-pago consignado que liberta sua vida financeira.</p>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i class="fas fa-shield-alt text-success"></i>
                        <span class="small text-light opacity-75">Parceria CPFL</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5 class="fw-bold mb-3 text-white">Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">Termos de Uso</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">Política de Privacidade</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">Contato</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">Rede Credenciada</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5 class="fw-bold mb-3 text-white">Suporte</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">Central de Ajuda</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">WhatsApp</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">E-mail</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light opacity-75 text-decoration-none hover-effect">Telefone</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-top border-secondary pt-4 text-center">
                <p class="text-light opacity-75 mb-0">&copy; 2024 Multiplic.cc. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/cadastro.js') }}"></script>
</body>
</html>
