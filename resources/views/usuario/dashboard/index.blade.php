<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuário | Multiplic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-credit-card"></i> Multiplic</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Olá, {{ $usuario->nome }}
                </span>
                <form method="POST" action="{{ route('usuario.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Cards de Saldo -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Saldo Pré-pago</h6>
                                <h3>R$ {{ number_format($saldoPrePago, 2, ',', '.') }}</h3>
                            </div>
                            <div>
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Saldo Mensalidade</h6>
                                <h3>R$ {{ number_format($saldoMensalidade, 2, ',', '.') }}</h3>
                            </div>
                            <div>
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Limite Consignado</h6>
                                <h3>R$ {{ number_format($saldoLimiteConsignado, 2, ',', '.') }}</h3>
                            </div>
                            <div>
                                <i class="fas fa-handshake fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Saldo Total Disponível</h6>
                                <h3>R$ {{ number_format($saldoTotal, 2, ',', '.') }}</h3>
                            </div>
                            <div>
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informação do Plano -->
        <div class="row mb-4">
            <div class="col-12">
                @if($usuario->meses_gratuitos > 0 && $usuario->data_fim_gratuidade && $usuario->data_fim_gratuidade->isFuture())
                    <div class="alert alert-info">
                        <i class="fas fa-gift"></i>
                        <strong>Mensalidade gratuita até {{ $usuario->data_fim_gratuidade->format('d/m/Y') }}</strong>
                        <br>
                        <small>Você ainda tem {{ $usuario->meses_gratuitos }} mês(es) gratuito(s).</small>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-credit-card"></i>
                        <strong>Mensalidade: R$ {{ number_format($usuario->valor_mensalidade, 2, ',', '.') }}/mês</strong>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-bolt"></i> Ações Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('usuario.recargas.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Adicionar Crédito
                        </a>
                        <a href="{{ route('usuario.recargas.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-history"></i> Histórico de Recargas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Histórico Recente -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-history"></i> Histórico Recente</h5>
                    </div>
                    <div class="card-body">
                        @if($historicoRecente->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Tipo</th>
                                            <th>Descrição</th>
                                            <th class="text-end">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($historicoRecente as $movimentacao)
                                            <tr>
                                                <td>{{ $movimentacao->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $movimentacao->ehCredito() ? 'success' : 'danger' }}">
                                                        {{ $movimentacao->ehCredito() ? 'Crédito' : 'Débito' }}
                                                    </span>
                                                </td>
                                                <td>{{ $movimentacao->descricao }}</td>
                                                <td class="text-end {{ $movimentacao->ehCredito() ? 'text-success' : 'text-danger' }}">
                                                    {{ $movimentacao->ehCredito() ? '+' : '-' }}R$ {{ number_format($movimentacao->valor, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Nenhuma movimentação encontrada.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
