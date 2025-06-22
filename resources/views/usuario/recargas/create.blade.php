<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Recarga | Multiplic</title>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-plus"></i> Solicitar Recarga de Crédito</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('usuario.recargas.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="valor" class="form-label">Valor da Recarga</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number"
                                           class="form-control @error('valor') is-invalid @enderror"
                                           id="valor"
                                           name="valor"
                                           value="{{ old('valor') }}"
                                           min="10"
                                           max="1000"
                                           step="0.01"
                                           placeholder="0,00"
                                           required>
                                </div>
                                <div class="form-text">Valor mínimo: R$ 10,00 | Valor máximo: R$ 1.000,00</div>
                                @error('valor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição (opcional)</label>
                                <textarea class="form-control @error('descricao') is-invalid @enderror"
                                          id="descricao"
                                          name="descricao"
                                          rows="3"
                                          placeholder="Informe o motivo da recarga ou observações">{{ old('descricao') }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Importante:</strong> Sua solicitação será analisada pelo administrador.
                                Você receberá uma confirmação após a aprovação e o crédito será adicionado ao seu saldo pré-pago.
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('usuario.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Solicitar Recarga
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
