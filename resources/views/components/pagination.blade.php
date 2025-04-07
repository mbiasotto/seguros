@if ($paginator->hasPages())
<div class="mt-3 d-flex justify-content-center">
    {{ $paginator->links() }}
</div>
@endif
