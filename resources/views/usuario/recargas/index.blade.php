<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Recargas | Multiplic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('usuario.dashboard') }}"><i class="fas fa-credit-card"></i> Multiplic</a>
            <div class="navbar-nav ms-auto">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-history"></i> Histórico de Recargas</h5>
                        <a href="{{ route('usuario.recargas.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nova Recarga
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($recargas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data Solicitação</th>
                                            <th>Valor</th>
                                            <th>Status</th>
                                            <th>Descrição</th>
                                            <th>Data Aprovação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recargas as $recarga)
                                            <tr>
                                                <td>{{ $recarga->created_at->format('d/m/Y H:i') }}</td>
                                                <td>R$ {{ number_format($recarga->valor, 2, ',', '.') }}</td>
                                                <td>
                                                    @if($recarga->status === 'pendente')
                                                        <span class="badge bg-warning">Pendente</span>
                                                    @elseif($recarga->status === 'confirmado')
                                                        <span class="badge bg-success">Confirmado</span>
                                                    @else
                                                        <span class="badge bg-danger">Cancelado</span>
                                                    @endif
                                                </td>
                                                <td>{{ $recarga->descricao ?: 'N/A' }}</td>
                                                <td>
                                                    @if($recarga->data_confirmacao)
                                                        {{ $recarga->data_confirmacao->format('d/m/Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginação -->
                            <div class="d-flex justify-content-center">
                                {{ $recargas->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhuma recarga encontrada</h5>
                                <p class="text-muted">Você ainda não fez nenhuma solicitação de recarga.</p>
                                <a href="{{ route('usuario.recargas.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Fazer Primeira Recarga
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('usuario.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
