@props(['transparent' => false])

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
