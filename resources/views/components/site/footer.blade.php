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
                        <a href="{{ route('site.termos') }}" class="text-light opacity-75 text-decoration-none hover-effect">Termos de Uso</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.privacidade') }}" class="text-light opacity-75 text-decoration-none hover-effect">Política de Privacidade</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.contato') }}" class="text-light opacity-75 text-decoration-none hover-effect">Contato</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.rede') }}" class="text-light opacity-75 text-decoration-none hover-effect">Rede Credenciada</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5 class="fw-bold mb-3 text-white">Suporte</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('site.ajuda') }}" class="text-light opacity-75 text-decoration-none hover-effect">Central de Ajuda</a>
                    </li>
                    <li class="mb-2">
                        <a href="https://wa.me/5511999999999?text=Olá! Preciso de ajuda com o cartão Multiplic.cc" class="text-light opacity-75 text-decoration-none hover-effect" target="_blank">WhatsApp</a>
                    </li>
                    <li class="mb-2">
                        <a href="mailto:suporte@multiplic.cc" class="text-light opacity-75 text-decoration-none hover-effect">E-mail</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('site.suporte') }}" class="text-light opacity-75 text-decoration-none hover-effect">Telefone</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-top border-secondary pt-4 text-center">
            <p class="text-light opacity-75 mb-0">&copy; {{ date('Y') }} Multiplic.cc. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
