{{--
    Componente de botão para voltar padronizado
    @param string $route Rota para onde o botão deve direcionar
--}}

@props(['route'])

<a href="{{ $route }}" class="btn btn-light d-flex align-items-center">
    <i class="fas fa-arrow-left me-2"></i>
    <span>Voltar</span>
</a>
