@extends('layouts.site')

@section('title', 'Termos de Uso - Multiplic.cc')

@section('content')
    <!-- Header Section -->
    <section class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Termos de Uso</h1>
                    <p class="lead">Conheça os termos e condições para utilização do Multiplic.cc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <p class="text-muted mb-4">
                                <strong>Última atualização:</strong> {{ date('d/m/Y') }}
                            </p>

                            <h3 class="fw-bold mb-4">1. Aceitação dos Termos</h3>
                            <p class="mb-4">
                                Ao acessar e utilizar o site Multiplic.cc e nossos serviços, você concorda em estar vinculado a estes Termos de Uso. Se você não concordar com qualquer parte destes termos, não utilize nossos serviços.
                            </p>

                            <h3 class="fw-bold mb-4">2. Descrição do Serviço</h3>
                            <p class="mb-4">
                                O Multiplic.cc é um cartão pré-pago consignado que oferece:
                            </p>
                            <ul class="mb-4">
                                <li>Cartão pré-pago sem anuidade</li>
                                <li>Débito automático na conta de energia elétrica</li>
                                <li>Rede credenciada exclusiva com mais de 1.000 estabelecimentos</li>
                                <li>Aprovação facilitada, mesmo para negativados</li>
                            </ul>

                            <h3 class="fw-bold mb-4">3. Elegibilidade</h3>
                            <p class="mb-4">
                                Para utilizar nossos serviços, você deve:
                            </p>
                            <ul class="mb-4">
                                <li>Ser maior de 18 anos</li>
                                <li>Possuir CPF válido</li>
                                <li>Ser titular de conta de energia elétrica da CPFL</li>
                                <li>Fornecer informações verdadeiras e atualizadas</li>
                            </ul>

                            <h3 class="fw-bold mb-4">4. Responsabilidades do Usuário</h3>
                            <p class="mb-4">
                                Você se compromete a:
                            </p>
                            <ul class="mb-4">
                                <li>Utilizar o cartão apenas para transações legítimas</li>
                                <li>Manter seus dados pessoais atualizados</li>
                                <li>Proteger suas informações de login e cartão</li>
                                <li>Notificar imediatamente sobre qualquer uso não autorizado</li>
                                <li>Pagar pontualmente os valores debitados</li>
                            </ul>

                            <h3 class="fw-bold mb-4">5. Taxas e Tarifas</h3>
                            <p class="mb-4">
                                O cartão Multiplic.cc não possui:
                            </p>
                            <ul class="mb-4">
                                <li>Taxa de anuidade</li>
                                <li>Taxa de manutenção</li>
                                <li>Taxa de emissão</li>
                            </ul>
                            <p class="mb-4">
                                Os valores utilizados no cartão serão debitados diretamente na sua conta de energia elétrica da CPFL.
                            </p>

                            <h3 class="fw-bold mb-4">6. Limitação de Responsabilidade</h3>
                            <p class="mb-4">
                                O Multiplic.cc não se responsabiliza por:
                            </p>
                            <ul class="mb-4">
                                <li>Indisponibilidade temporária dos serviços</li>
                                <li>Problemas técnicos em estabelecimentos credenciados</li>
                                <li>Uso indevido do cartão por terceiros</li>
                                <li>Danos decorrentes de falhas na rede de energia elétrica</li>
                            </ul>

                            <h3 class="fw-bold mb-4">7. Modificações dos Termos</h3>
                            <p class="mb-4">
                                Reservamo-nos o direito de modificar estes termos a qualquer momento. As alterações serão comunicadas através de nosso site e entrarão em vigor imediatamente após a publicação.
                            </p>

                            <h3 class="fw-bold mb-4">8. Rescisão</h3>
                            <p class="mb-4">
                                Podemos suspender ou encerrar sua conta a qualquer momento, sem aviso prévio, em caso de violação destes termos ou uso inadequado dos serviços.
                            </p>

                            <h3 class="fw-bold mb-4">9. Lei Aplicável</h3>
                            <p class="mb-4">
                                Estes termos são regidos pelas leis brasileiras. Qualquer disputa será resolvida no foro da comarca onde está localizada a sede da empresa.
                            </p>

                            <h3 class="fw-bold mb-4">10. Contato</h3>
                            <p class="mb-0">
                                Para dúvidas sobre estes termos, entre em contato conosco através da nossa <a href="{{ route('site.contato') }}" class="text-warning">página de contato</a> ou pelos canais de atendimento disponíveis em nosso site.
                            </p>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('site.index') }}" class="btn btn-warning fw-bold text-dark px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i>Voltar ao Início
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
