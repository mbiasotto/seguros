@extends('admin.layouts.app')

@section('title', 'Editar Contrato')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Editar Contrato</h1>
        @include('admin.components.back-button', ['route' => route('admin.contratos.show', $contrato)])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.contratos.update', $contrato) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">Dados do Contrato</h5>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numero_contrato" class="form-label">Número do Contrato</label>
                                    <input type="text" class="form-control form-control-lg"
                                           id="numero_contrato" name="numero_contrato"
                                           value="{{ $contrato->numero_contrato }}" readonly>
                                    <small class="form-text text-muted text-sm">Gerado automaticamente pelo sistema</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cliente" class="form-label">Cliente</label>
                                    <input type="text" class="form-control form-control-lg"
                                           id="cliente" name="cliente"
                                           value="{{ $contrato->usuario->nome }} - {{ $contrato->usuario->email }}" readonly>
                                    <small class="form-text text-muted text-sm">Não é possível alterar o cliente após criação</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pendente_cpfl" {{ $contrato->status === 'pendente_cpfl' ? 'selected' : '' }}>Pendente CPFL</option>
                                        <option value="ativo" {{ $contrato->status === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                        <option value="cancelado" {{ $contrato->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <input type="text" class="form-control form-control-lg"
                                           id="tipo" name="tipo"
                                           value="{{ ucfirst($contrato->tipo) }}" readonly>
                                    <small class="form-text text-muted text-sm">Não é possível alterar o tipo após criação</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="protocolo_cpfl" class="form-label">Protocolo CPFL</label>
                                    <input type="text" class="form-control form-control-lg @error('protocolo_cpfl') is-invalid @enderror"
                                           id="protocolo_cpfl" name="protocolo_cpfl"
                                           value="{{ old('protocolo_cpfl', $contrato->protocolo_cpfl) }}"
                                           placeholder="Digite o protocolo CPFL">
                                    @error('protocolo_cpfl')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="protocolo_cancelamento" class="form-label">Protocolo de Cancelamento</label>
                                    <input type="text" class="form-control form-control-lg @error('protocolo_cancelamento') is-invalid @enderror"
                                           id="protocolo_cancelamento" name="protocolo_cancelamento"
                                           value="{{ old('protocolo_cancelamento', $contrato->protocolo_cancelamento) }}"
                                           placeholder="Digite o protocolo de cancelamento">
                                    <small class="form-text text-muted text-sm">Necessário apenas se o contrato for cancelado</small>
                                    @error('protocolo_cancelamento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.contratos.show', $contrato) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-times me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-save me-2"></i> Atualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card de Informações -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">Informações do Contrato</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <strong>Score Inicial:</strong>
                            <p class="text-primary">{{ $contrato->score_inicial ?? 'N/A' }}</p>
                        </div>

                        <div class="info-item mb-3">
                            <strong>Limite Inicial:</strong>
                            <p class="text-success">R$ {{ number_format($contrato->limite_inicial ?? 0, 2, ',', '.') }}</p>
                        </div>

                        <div class="info-item mb-3">
                            <strong>Data de Criação:</strong>
                            <p>{{ $contrato->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        @if($contrato->enviado_cpfl_em)
                        <div class="info-item mb-3">
                            <strong>Enviado CPFL em:</strong>
                            <p>{{ $contrato->enviado_cpfl_em->format('d/m/Y H:i:s') }}</p>
                        </div>
                        @endif

                        @if($contrato->data_proxima_revisao_score)
                        <div class="info-item mb-3">
                            <strong>Próxima Revisão de Score:</strong>
                            <p>{{ $contrato->data_proxima_revisao_score->format('d/m/Y') }}</p>
                        </div>
                        @endif

                        <div class="info-item mb-3">
                            <strong>Última Atualização:</strong>
                            <p>{{ $contrato->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
