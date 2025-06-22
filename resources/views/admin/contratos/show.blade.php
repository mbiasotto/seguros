@extends('admin.layouts.app')

@section('title', 'Detalhes do Contrato')

@section('content')
<div class="page-header">
    <div class="page-header-title">
        <h1>
            <i class="fas fa-file-contract text-primary me-2"></i>
            Contrato {{ $contrato->numero_contrato }}
        </h1>
        <p class="page-description">Visualizar detalhes do contrato</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.contratos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Voltar
        </a>
        <a href="{{ route('admin.contratos.edit', $contrato) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>
            Editar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informações do Contrato
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Número do Contrato:</strong>
                        <p>{{ $contrato->numero_contrato }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tipo:</strong>
                        <p>
                            @if($contrato->tipo === 'site')
                                <span class="badge bg-info">Site</span>
                            @else
                                <span class="badge bg-warning">Avulso</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            @if($contrato->status === 'pendente_cpfl')
                                <span class="badge bg-warning">Pendente CPFL</span>
                            @elseif($contrato->status === 'ativo')
                                <span class="badge bg-success">Ativo</span>
                            @elseif($contrato->status === 'cancelado')
                                <span class="badge bg-danger">Cancelado</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Data de Criação:</strong>
                        <p>{{ $contrato->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                @if($contrato->protocolo_cpfl)
                <div class="row">
                    <div class="col-md-6">
                        <strong>Protocolo CPFL:</strong>
                        <p>{{ $contrato->protocolo_cpfl }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Enviado CPFL em:</strong>
                        <p>{{ $contrato->enviado_cpfl_em ? $contrato->enviado_cpfl_em->format('d/m/Y H:i:s') : 'N/A' }}</p>
                    </div>
                </div>
                @endif

                @if($contrato->protocolo_cancelamento)
                <div class="row">
                    <div class="col-md-12">
                        <strong>Protocolo de Cancelamento:</strong>
                        <p>{{ $contrato->protocolo_cancelamento }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Dados do Cliente
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nome:</strong>
                        <p>{{ $contrato->usuario->nome }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>E-mail:</strong>
                        <p>{{ $contrato->usuario->email }}</p>
                    </div>
                </div>

                @if($contrato->usuario->numero_cartao)
                <div class="row">
                    <div class="col-md-6">
                        <strong>Número do Cartão:</strong>
                        <p>{{ $contrato->usuario->numero_cartao }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Validade do Cartão:</strong>
                        <p>{{ $contrato->usuario->validade_cartao ? $contrato->usuario->validade_cartao->format('m/Y') : 'N/A' }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Score e Limite
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Score Inicial:</strong>
                    <p class="text-primary h5">{{ $contrato->score_inicial ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Limite Inicial:</strong>
                    <p class="text-success h5">R$ {{ number_format($contrato->limite_inicial ?? 0, 2, ',', '.') }}</p>
                </div>

                @if($contrato->usuario->score_atual)
                <div class="mb-3">
                    <strong>Score Atual:</strong>
                    <p class="text-info h5">{{ $contrato->usuario->score_atual }}</p>
                </div>
                @endif

                @if($contrato->usuario->limite_credito_manual)
                <div class="mb-3">
                    <strong>Limite Atual:</strong>
                    <p class="text-success h5">R$ {{ number_format($contrato->usuario->limite_credito_manual, 2, ',', '.') }}</p>
                </div>
                @endif

                @if($contrato->data_proxima_revisao_score)
                <div class="mb-3">
                    <strong>Próxima Revisão:</strong>
                    <p>{{ $contrato->data_proxima_revisao_score->format('d/m/Y') }}</p>
                </div>
                @endif
            </div>
        </div>

        @if($contrato->status === 'pendente_cpfl')
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Ações
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contratos.ativar', $contrato) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Confirma a ativação do contrato?')">
                        <i class="fas fa-check me-2"></i>
                        Ativar Contrato
                    </button>
                </form>

                <form action="{{ route('admin.contratos.cancelar', $contrato) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Confirma o cancelamento do contrato?')">
                        <i class="fas fa-times me-2"></i>
                        Cancelar Contrato
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
