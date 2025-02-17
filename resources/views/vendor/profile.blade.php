<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Área do Vendedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Área do Vendedor</a>
            <form action="{{ route('vendor.logout') }}" method="POST" class="ms-auto">
                @csrf
                <button type="submit" class="btn btn-light">Sair</button>
            </form>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0">Meu Perfil</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('vendor.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" value="{{ $vendor->nome }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" value="{{ $vendor->email }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $vendor->telefone) }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco', $vendor->endereco) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade', $vendor->cidade) }}">
                                </div>

                                <div class="col-md-2">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado" maxlength="2" value="{{ old('estado', $vendor->estado) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep', $vendor->cep) }}">
                                </div>

                                <div class="col-12">
                                    <hr class="my-4">
                                    <h5>Alterar Senha</h5>
                                    <p class="text-muted small">Preencha apenas se desejar alterar sua senha</p>
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
