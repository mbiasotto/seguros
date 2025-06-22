<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estabelecimentos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1>Estabelecimentos</h1>
                    <a href="{{ route('admin.estabelecimentos.create') }}" class="btn btn-primary">
                        Novo Estabelecimento
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>CNPJ</th>
                                        <th>Nome Fantasia</th>
                                        <th>Email</th>
                                        <th>Categoria</th>
                                        <th>Status</th>
                                        <th>Taxa Multiplic</th>
                                        <th>Criado em</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($estabelecimentos as $estabelecimento)
                                        <tr>
                                            <td>{{ $estabelecimento->cnpj_formatado }}</td>
                                            <td>{{ $estabelecimento->nome_fantasia }}</td>
                                            <td>{{ $estabelecimento->email }}</td>
                                            <td>{{ $estabelecimento->categoria_formatada }}</td>
                                            <td>
                                                <span class="badge bg-{{ $estabelecimento->status === 'ativo' ? 'success' : ($estabelecimento->status === 'bloqueado' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($estabelecimento->status) }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($estabelecimento->taxa_multiplic, 2, ',', '.') }}%</td>
                                            <td>{{ $estabelecimento->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="#" class="btn btn-outline-primary">Ver</a>
                                                    <a href="#" class="btn btn-outline-secondary">Editar</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Nenhum estabelecimento encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $estabelecimentos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
