@extends('layouts.site')

@section('title', 'Política de Privacidade - Multiplic.cc')

@section('content')
    <!-- Header Section -->
    <section class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Política de Privacidade</h1>
                    <p class="lead">Saiba como protegemos suas informações pessoais</p>
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

                            <h3 class="fw-bold mb-4">1. Introdução</h3>
                            <p class="mb-4">
                                O Multiplic.cc valoriza sua privacidade e está comprometido em proteger suas informações pessoais. Esta Política de Privacidade explica como coletamos, usamos, armazenamos e protegemos seus dados de acordo com a Lei Geral de Proteção de Dados (LGPD).
                            </p>

                            <h3 class="fw-bold mb-4">2. Informações que Coletamos</h3>
                            <p class="mb-4">
                                Coletamos as seguintes informações:
                            </p>
                            <ul class="mb-4">
                                <li><strong>Dados pessoais:</strong> Nome completo, CPF, RG, data de nascimento</li>
                                <li><strong>Dados de contato:</strong> E-mail, telefone, endereço residencial</li>
                                <li><strong>Dados financeiros:</strong> Número da conta CPFL, histórico de pagamentos</li>
                                <li><strong>Dados de navegação:</strong> IP, cookies, páginas visitadas</li>
                                <li><strong>Dados de transações:</strong> Compras realizadas com o cartão</li>
                            </ul>

                            <h3 class="fw-bold mb-4">3. Como Usamos suas Informações</h3>
                            <p class="mb-4">
                                Utilizamos seus dados para:
                            </p>
                            <ul class="mb-4">
                                <li>Processar sua solicitação de cartão</li>
                                <li>Realizar análise de crédito e aprovação</li>
                                <li>Processar transações e pagamentos</li>
                                <li>Enviar comunicações importantes sobre sua conta</li>
                                <li>Melhorar nossos serviços e experiência do usuário</li>
                                <li>Cumprir obrigações legais e regulatórias</li>
                                <li>Prevenir fraudes e atividades suspeitas</li>
                            </ul>

                            <h3 class="fw-bold mb-4">4. Compartilhamento de Informações</h3>
                            <p class="mb-4">
                                Podemos compartilhar suas informações com:
                            </p>
                            <ul class="mb-4">
                                <li><strong>CPFL:</strong> Para processamento de débitos automáticos</li>
                                <li><strong>Estabelecimentos credenciados:</strong> Para processamento de transações</li>
                                <li><strong>Órgãos reguladores:</strong> Quando exigido por lei</li>
                                <li><strong>Parceiros de segurança:</strong> Para prevenção de fraudes</li>
                                <li><strong>Prestadores de serviços:</strong> Que nos auxiliam na operação</li>
                            </ul>
                            <p class="mb-4">
                                <strong>Importante:</strong> Nunca vendemos seus dados pessoais para terceiros.
                            </p>

                            <h3 class="fw-bold mb-4">5. Segurança dos Dados</h3>
                            <p class="mb-4">
                                Implementamos medidas de segurança robustas:
                            </p>
                            <ul class="mb-4">
                                <li>Criptografia de dados em trânsito e em repouso</li>
                                <li>Controles de acesso rigorosos</li>
                                <li>Monitoramento contínuo de segurança</li>
                                <li>Auditorias regulares de segurança</li>
                                <li>Treinamento regular da equipe</li>
                            </ul>

                            <h3 class="fw-bold mb-4">6. Seus Direitos (LGPD)</h3>
                            <p class="mb-4">
                                Você tem os seguintes direitos sobre seus dados:
                            </p>
                            <ul class="mb-4">
                                <li><strong>Acesso:</strong> Solicitar informações sobre dados processados</li>
                                <li><strong>Correção:</strong> Corrigir dados incompletos ou inexatos</li>
                                <li><strong>Exclusão:</strong> Solicitar a exclusão de dados desnecessários</li>
                                <li><strong>Portabilidade:</strong> Solicitar transferência dos dados</li>
                                <li><strong>Oposição:</strong> Opor-se ao processamento de dados</li>
                                <li><strong>Revogação de consentimento:</strong> Retirar consentimento a qualquer momento</li>
                            </ul>

                            <h3 class="fw-bold mb-4">7. Retenção de Dados</h3>
                            <p class="mb-4">
                                Mantemos seus dados pelo período necessário para:
                            </p>
                            <ul class="mb-4">
                                <li>Cumprir a finalidade para qual foram coletados</li>
                                <li>Atender obrigações legais (até 5 anos após encerramento)</li>
                                <li>Resolver disputas ou questões legais</li>
                                <li>Exercer direitos em processos judiciais</li>
                            </ul>

                            <h3 class="fw-bold mb-4">8. Cookies e Tecnologias Similares</h3>
                            <p class="mb-4">
                                Utilizamos cookies para:
                            </p>
                            <ul class="mb-4">
                                <li>Melhorar a funcionalidade do site</li>
                                <li>Personalizar sua experiência</li>
                                <li>Analisar o tráfego do site</li>
                                <li>Fornecer recursos de segurança</li>
                            </ul>
                            <p class="mb-4">
                                Você pode gerenciar suas preferências de cookies nas configurações do seu navegador.
                            </p>

                            <h3 class="fw-bold mb-4">9. Menores de Idade</h3>
                            <p class="mb-4">
                                Nossos serviços são destinados apenas a maiores de 18 anos. Não coletamos intencionalmente dados de menores de idade.
                            </p>

                            <h3 class="fw-bold mb-4">10. Alterações nesta Política</h3>
                            <p class="mb-4">
                                Esta política pode ser atualizada periodicamente. Notificaremos sobre mudanças significativas através de nosso site ou por e-mail.
                            </p>

                            <h3 class="fw-bold mb-4">11. Contato e DPO</h3>
                            <p class="mb-4">
                                Para exercer seus direitos ou esclarecer dúvidas sobre privacidade:
                            </p>
                            <ul class="mb-4">
                                <li><strong>E-mail:</strong> privacidade@multiplic.cc</li>
                                <li><strong>Página de contato:</strong> <a href="{{ route('site.contato') }}" class="text-warning">Clique aqui</a></li>
                                <li><strong>Encarregado de Proteção de Dados (DPO):</strong> dpo@multiplic.cc</li>
                            </ul>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Importante:</strong> Caso não esteja satisfeito com nossas respostas, você pode entrar em contato com a Autoridade Nacional de Proteção de Dados (ANPD).
                            </div>
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
