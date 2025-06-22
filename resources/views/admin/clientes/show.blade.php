@extends('admin.layouts.app')

@section('title', 'Detalhes do Cliente')

@section('content')
<div class="page-header">
    <div class="page-header-title">
        <h1>
            <i class="fas fa-user text-primary me-2"></i>
            {{ $cliente->nome }}
        </h1>
        <p class="page-description">Visualizar informações completas do cliente</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Voltar
        </a>
        <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>
            Editar
        </a>
        @if(!$cliente->contrato)
            <a href="{{ route('admin.contratos.create', ['usuario_id' => $cliente->id]) }}" class="btn btn-success">
                <i class="fas fa-file-contract me-2"></i>
                Criar Contrato
            </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Dados Básicos -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-circle me-2"></i>
                    Dados Pessoais
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nome:</strong>
                        <p>{{ $cliente->nome }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>E-mail:</strong>
                        <p>{{ $cliente->email }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>CPF:</strong>
                        <p>{{ $cliente->cpf ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Telefone:</strong>
                        <p>{{ $cliente->telefone ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <strong>Data de Cadastro:</strong>
                        <p>{{ $cliente->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dados do Cartão -->
        @if($cliente->numero_cartao)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-credit-card me-2"></i>
                    Dados do Cartão
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Número do Cartão:</strong>
                        <p class="font-monospace">{{ $cliente->numero_cartao }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Validade:</strong>
                        <p>{{ $cliente->validade_cartao ? $cliente->validade_cartao->format('m/Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Informações de Contrato -->
        @if($cliente->contrato)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-contract me-2"></i>
                    Informações do Contrato
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Número do Contrato:</strong>
                        <p>
                            <a href="{{ route('admin.contratos.show', $cliente->contrato) }}" class="text-decoration-none">
                                {{ $cliente->contrato->numero_contrato }}
                                <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            @if($cliente->contrato->status === 'pendente_cpfl')
                                <span class="badge bg-warning">Pendente CPFL</span>
                            @elseif($cliente->contrato->status === 'ativo')
                                <span class="badge bg-success">Ativo</span>
                            @elseif($cliente->contrato->status === 'cancelado')
                                <span class="badge bg-danger">Cancelado</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Tipo:</strong>
                        <p>
                            @if($cliente->contrato->tipo === 'site')
                                <span class="badge bg-info">Site</span>
                            @else
                                <span class="badge bg-secondary">Avulso</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Data do Contrato:</strong>
                        <p>{{ $cliente->contrato->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Score e Limite -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Score e Limite
                </h6>
            </div>
            <div class="card-body">
                @if($cliente->score_atual)
                <div class="mb-3">
                    <strong>Score Atual:</strong>
                    <p class="text-primary h5">{{ $cliente->score_atual }}</p>
                    <small class="text-muted">
                        Última consulta: {{ $cliente->data_ultima_consulta_score ? $cliente->data_ultima_consulta_score->format('d/m/Y') : 'N/A' }}
                    </small>
                </div>
                @endif

                @if($cliente->limite_credito_sugerido)
                <div class="mb-3">
                    <strong>Limite Sugerido:</strong>
                    <p class="text-info h6">R$ {{ number_format($cliente->limite_credito_sugerido, 2, ',', '.') }}</p>
                </div>
                @endif

                @if($cliente->limite_credito_manual)
                <div class="mb-3">
                    <strong>Limite Aprovado:</strong>
                    <p class="text-success h5">R$ {{ number_format($cliente->limite_credito_manual, 2, ',', '.') }}</p>

                    @if($cliente->limite_aprovado_por)
                    <small class="text-muted d-block">
                        Aprovado por: {{ $cliente->adminLimiteAprovadoPor->name ?? 'N/A' }}
                    </small>
                    @endif

                    @if($cliente->data_aprovacao_limite)
                    <small class="text-muted d-block">
                        Em: {{ $cliente->data_aprovacao_limite->format('d/m/Y H:i') }}
                    </small>
                    @endif
                </div>
                @endif

                @if($cliente->motivo_limite_manual)
                <div class="mb-3">
                    <strong>Justificativa do Limite:</strong>
                    <p class="text-muted small">{{ $cliente->motivo_limite_manual }}</p>
                </div>
                @endif

                @if($cliente->contrato && !$cliente->limite_credito_manual)
                <div class="d-grid">
                    <a href="{{ route('admin.usuarios.definir-limite', $cliente) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-cog me-2"></i>
                        Definir Limite
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Status -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Status
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Contrato:</strong>
                    @if($cliente->contrato)
                        <span class="badge bg-success">Possui</span>
                    @else
                        <span class="badge bg-warning">Sem contrato</span>
                    @endif
                </div>

                <div class="mb-2">
                    <strong>Score:</strong>
                    @if($cliente->score_atual)
                        <span class="badge bg-info">Consultado</span>
                    @else
                        <span class="badge bg-secondary">Não consultado</span>
                    @endif
                </div>

                <div class="mb-2">
                    <strong>Limite:</strong>
                    @if($cliente->limite_credito_manual)
                        <span class="badge bg-success">Definido</span>
                    @else
                        <span class="badge bg-warning">Pendente</span>
                    @endif
                </div>

                @if($cliente->contrato && $cliente->contrato->precisaRevisaoScore())
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Atenção:</strong> Score precisa ser revisado!
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
