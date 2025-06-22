@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 50%, #17a2b8 100%);">
    <div class="card shadow-lg" style="max-width: 600px; border-radius: 20px;">
        <div class="card-body text-center p-5">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
            </div>

            <h1 class="display-5 fw-bold text-success mb-3">Parabéns!</h1>
            <p class="lead text-muted mb-4">Seu cadastro foi realizado com sucesso!</p>

            <div class="alert alert-success" role="alert">
                <h5 class="alert-heading">
                    <i class="fas fa-envelope me-2"></i>
                    E-mail de Confirmação Enviado
                </h5>
                <p class="mb-1">
                    <strong>Para:</strong> {{ session('cliente_email', 'seu-email@exemplo.com') }}
                </p>
                <hr>
                <p class="mb-0 small">
                    Verifique sua caixa de entrada e também a pasta de spam.
                </p>
            </div>

            <div class="alert alert-warning" role="alert">
                <h5 class="alert-heading">
                    <i class="fas fa-clock me-2"></i>
                    Próximos Passos
                </h5>
                <ul class="list-unstyled text-start mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Análise:</strong> Em até 24 horas
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Aprovação:</strong> E-mail com resultado
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Cartão:</strong> Entrega em até 7 dias
                    </li>
                </ul>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <a href="https://wa.me/5511999999999" class="btn btn-outline-success w-100" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>
                        WhatsApp
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="mailto:suporte@multiplic.cc" class="btn btn-outline-primary w-100">
                        <i class="fas fa-envelope me-2"></i>
                        E-mail
                    </a>
                </div>
            </div>

            <a href="{{ route('site.index') }}" class="btn btn-success btn-lg px-5">
                <i class="fas fa-home me-2"></i>
                Voltar ao Site
            </a>
        </div>
    </div>
</div>
@endsection
