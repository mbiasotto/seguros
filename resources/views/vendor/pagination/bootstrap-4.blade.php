@if ($paginator->hasPages())
    <nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            {{-- Primeiro número sempre será 1 --}}
            <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>

            {{-- Se tivermos mais de uma página --}}
            @if($paginator->lastPage() > 1)
                {{-- Exibir página 2 --}}
                <li class="page-item {{ $paginator->currentPage() == 2 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url(2) }}">2</a>
                </li>
            @endif

            {{-- Se tivermos mais de duas páginas --}}
            @if($paginator->lastPage() > 2)
                {{-- Exibir página 3 --}}
                <li class="page-item {{ $paginator->currentPage() == 3 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url(3) }}">3</a>
                </li>
            @endif

            {{-- Se tivermos mais de três páginas --}}
            @if($paginator->lastPage() > 3)
                {{-- Exibir página 4 --}}
                <li class="page-item {{ $paginator->currentPage() == 4 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url(4) }}">4</a>
                </li>
            @endif

            {{-- Se tivermos mais de quatro páginas --}}
            @if($paginator->lastPage() > 4)
                {{-- Exibir página 3 (ou outra página) como último item --}}
                <li class="page-item {{ $paginator->currentPage() > 4 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url(min(5, $paginator->lastPage())) }}">{{ min(5, $paginator->lastPage()) }}</a>
                </li>
            @endif
        </ul>
    </nav>
@endif