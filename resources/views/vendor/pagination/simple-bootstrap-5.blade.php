@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-sm justify-content-center">
            {{-- Página 1 --}}
            <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>

            {{-- Se tivermos mais de uma página e não for a primeira --}}
            @if($paginator->currentPage() > 1)
                <li class="page-item active">
                    <span class="page-link">{{ $paginator->currentPage() }}</span>
                </li>
            @endif

            {{-- Se tivermos mais páginas após a atual --}}
            @if($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">{{ $paginator->currentPage() + 1 }}</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
