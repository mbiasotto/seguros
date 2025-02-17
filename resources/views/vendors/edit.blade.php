<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Vendedor - Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Painel Administrativo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vendors.index') }}">Vendedores</a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-light">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Editar Vendedor</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('vendors.update', $vendor) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $vendor->nome) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $vendor->email) }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $vendor->telefone) }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco', $vendor->endereco) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade', $vendor->cidade) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado" maxlength="2" value="{{ old('estado', $vendor->estado) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep', $vendor->cep) }}">
                                </div>

                                <div class="col-12">
                                    <label for="observacoes" class="form-label">Observações</label>
                                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3">{{ old('observacoes', $vendor->observacoes) }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Nova Senha (opcional)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $vendor->ativo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ativo">Ativo</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                    <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancelar</a>
                                </div>
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
