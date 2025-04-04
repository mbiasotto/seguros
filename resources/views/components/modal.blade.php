@props([
    'id' => 'modal',
    'title' => '',
    'size' => '',
    'closeButton' => true,
    'staticBackdrop' => false
])

<div
    class="modal fade modal-modern"
    id="{{ $id }}"
    tabindex="-1"
    aria-labelledby="{{ $id }}Label"
    aria-hidden="true"
    @if($staticBackdrop) data-bs-backdrop="static" data-bs-keyboard="false" @endif
>
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            @if ($title)
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                    @if ($closeButton)
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    @endif
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @if (isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
