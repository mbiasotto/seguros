@props(['qrCodes', 'establishment' => null])

<div class="row mb-4">
    <div class="col-12">
        <div class="mb-3">
            <label class="form-label">Selecione os QR Codes para este estabelecimento</label>

            <!-- Seleção de QR Codes disponíveis -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="qrcode-search" placeholder="Filtrar QR Codes..." aria-label="Filtrar QR Codes">
                        <select class="form-select" id="qrcode-select">
                            <option value="">Selecione um QR Code disponível</option>
                            @foreach($qrCodes as $qrCode)
                                @if($establishment ? $qrCode->isAvailableFor($establishment) && !$establishment->qrCodes->contains($qrCode->id) : $qrCode->isAvailableFor())
                                    <option value="{{ $qrCode->id }}"
                                            data-title="QR Code #{{ $qrCode->id }}"
                                            data-description="{{ $qrCode->description ?: $qrCode->link }}">
                                        QR Code #{{ $qrCode->id }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary w-100 font-medium" id="add-qrcode-btn">
                        <i class="fas fa-plus me-2"></i> Adicionar QR Code
                    </button>
                </div>
            </div>

            <!-- Lista de QR Codes vinculados -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="font-medium mb-0">QR Codes vinculados a este estabelecimento</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="linked-qrcodes-list">
                        @if($establishment && $establishment->qrCodes->count() > 0)
                            @foreach($establishment->qrCodes as $qrCode)
                                <li class="list-group-item" id="linked-qrcode-{{ $qrCode->id }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <input type="hidden" name="qr_codes[]" value="{{ $qrCode->id }}">
                                            <strong class="font-medium">QR Code #{{ $qrCode->id }}</strong>
                                            <small class="text-muted text-sm d-block"></small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-qrcode"
                                                data-id="{{ $qrCode->id }}"
                                                data-title="QR Code #{{ $qrCode->id }}"
                                                data-description="{{ $qrCode->description ?: $qrCode->link }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="form-floating">
                                        <textarea class="form-control" name="qr_notes[{{ $qrCode->id }}]" id="qr-notes-{{ $qrCode->id }}" style="height: 80px" placeholder="Anotações sobre este QR Code">{{ $qrCode->pivot->notes ?? '' }}</textarea>
                                        <label for="qr-notes-{{ $qrCode->id }}">Anotações</label>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item text-center py-4" id="no-qrcodes-message">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i> Nenhum QR Code vinculado a este estabelecimento.
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script com dados do QR Code -->
<script id="page-qr-code-data" type="application/json">
    {!! json_encode([
        'allQrCodes' => (array) $qrCodes->map(function($qr) { return ['id' => $qr->id, 'title' => 'QR Code #' . $qr->id, 'description' => $qr->description ?: $qr->link]; })->values()->all(),
        'establishmentQrCodes' => $establishment ? (array) $establishment->qrCodes->map(function($qr) { return ['id' => $qr->id, 'title' => 'QR Code #' . $qr->id, 'description' => $qr->description ?: $qr->link, 'notes' => $qr->pivot->notes ?? '']; })->values()->all() : [],
        'oldQrCodes' => old('qr_codes', [])
    ]) !!}
</script>
