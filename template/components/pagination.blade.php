@props(['paginator'])

@if ($paginator->total() > 0)
<div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">

    @if ($paginator->hasPages())
    <div class="pagination-info mb-2 mb-md-0">
        {{ $paginator->firstItem() ?? 0 }} a {{ $paginator->lastItem() ?? 0 }} de {{ $paginator->total() }} resultados
    </div>
    <nav aria-label="Paginação">
        <ul class="pagination pagination-sm mb-0">
            {{-- Botão Anterior --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Anterior">
                    <span aria-hidden="true"><i class="fas fa-angle-left"></i></span>
                </a>
            </li>

            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $window = 2; // Número de páginas visíveis antes e depois da atual
            @endphp

            {{-- Primeira página --}}
            @if($currentPage > ($window + 2))
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif

            {{-- Páginas do intervalo --}}
            @for($i = max(1, $currentPage - $window); $i <= min($lastPage, $currentPage + $window); $i++)
                <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Última página --}}
            @if($currentPage < ($lastPage - $window - 1))
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Botão Próximo --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Próximo">
                    <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
    @endif
</div>
@endif
