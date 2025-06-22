<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Estabelecimento | Multiplic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-store"></i> Multiplic</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    {{ $estabelecimento->nome_fantasia }}
                </span>
                <form method="POST" action="{{ route('estabelecimento.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Informações do Estabelecimento -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5><i class="fas fa-store"></i> Informações do Estabelecimento</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Nome:</strong> {{ $estabelecimento->nome_fantasia }}</h6>
                                <p><strong>Razão Social:</strong> {{ $estabelecimento->razao_social }}</p>
                                <p><strong>CNPJ:</strong> {{ $estabelecimento->cnpj_formatado }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{ $estabelecimento->status === 'ativo' ? 'success' : ($estabelecimento->status === 'pendente' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($estabelecimento->status) }}
                                    </span>
                                </p>
                                <p><strong>Categoria:</strong> {{ $estabelecimento->categoria->nome ?? 'N/A' }}</p>
                                <p><strong>E-mail:</strong> {{ $estabelecimento->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taxas -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Taxa Multiplic</h6>
                                <h3>{{ number_format($estabelecimento->taxa_multiplic, 1, ',', '.') }}%</h3>
                            </div>
                            <div>
                                <i class="fas fa-percentage fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Taxa Estabelecimento</h6>
                                <h3>{{ number_format($estabelecimento->taxa_estabelecimento, 1, ',', '.') }}%</h3>
                            </div>
                            <div>
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vendas Hoje -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total vendas hoje</h6>
                                <h3>R$ {{ number_format($vendasHoje, 2, ',', '.') }}</h3>
                                <small>{{ now()->format('d/m/Y') }}</small>
                            </div>
                            <div>
                                <i class="fas fa-cash-register fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <button class="btn btn-success btn-lg me-2" onclick="alert('Funcionalidade em desenvolvimento')">
                            <i class="fas fa-plus"></i> Nova Venda
                        </button>
                        <button class="btn btn-outline-primary" onclick="alert('Funcionalidade em desenvolvimento')">
                            <i class="fas fa-chart-line"></i> Relatório de Vendas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumo de Performance (placeholder) -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-week fa-2x text-muted mb-2"></i>
                        <h6>Vendas Esta Semana</h6>
                        <h4 class="text-muted">R$ 0,00</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-2x text-muted mb-2"></i>
                        <h6>Vendas Este Mês</h6>
                        <h4 class="text-muted">R$ 0,00</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x text-muted mb-2"></i>
                        <h6>Clientes Atendidos</h6>
                        <h4 class="text-muted">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
