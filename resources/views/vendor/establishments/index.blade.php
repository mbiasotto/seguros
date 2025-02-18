<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estabelecimentos - Área do Vendedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Área do Vendedor</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vendor.profile') }}">Meu Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('vendor.establishments.index') }}">Estabelecimentos</a>
                    </li>
                </ul>
                <form action="{{ route('vendor.logout') }}" method="POST" class="ms-auto">
                    @csrf
                    <button type="submit" class="btn btn-light">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Meus Estabelecimentos</h2>
            <a href="{{ route('vendor.establishments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Novo Estabelecimento
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if($establishments->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-shop text-muted" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Nenhum estabelecimento cadastrado</h4>
                    <p class="text-muted">Clique no botão "Novo Estabelecimento" para começar.</p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Cidade/Estado</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($establishments as $establishment)
                                <tr>
                                    <td>{{ $establishment->nome }}</td>
                                    <td>{{ $establishment->cidade }}/{{ $establishment->estado }}</td>
                                    <td>{{ $establishment->telefone }}</td>
                                    <td>
                                        @if($establishment->ativo)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-danger">Inativo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('vendor.establishments.edit', $establishment) }}" class="btn btn-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('vendor.establishments.destroy', $establishment) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este estabelecimento?')" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $establishments->links() }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
