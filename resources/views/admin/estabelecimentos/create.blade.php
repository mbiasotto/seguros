<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Estabelecimento - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1>Novo Estabelecimento</h1>
                    <a href="{{ route('admin.estabelecimentos.index') }}" class="btn btn-secondary">
                        Voltar
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.estabelecimentos.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cnpj" class="form-label">CNPJ *</label>
                                        <input type="text" class="form-control @error('cnpj') is-invalid @enderror"
                                               id="cnpj" name="cnpj" value="{{ old('cnpj') }}" required>
                                        @error('cnpj')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="razao_social" class="form-label">Razão Social *</label>
                                        <input type="text" class="form-control @error('razao_social') is-invalid @enderror"
                                               id="razao_social" name="razao_social" value="{{ old('razao_social') }}" required>
                                        @error('razao_social')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nome_fantasia" class="form-label">Nome Fantasia *</label>
                                        <input type="text" class="form-control @error('nome_fantasia') is-invalid @enderror"
                                               id="nome_fantasia" name="nome_fantasia" value="{{ old('nome_fantasia') }}" required>
                                        @error('nome_fantasia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="categoria" class="form-label">Categoria *</label>
                                        <select class="form-select @error('categoria') is-invalid @enderror"
                                                id="categoria" name="categoria" required>
                                            <option value="">Selecione uma categoria</option>
                                            @foreach($categorias as $key => $value)
                                                <option value="{{ $key }}" {{ old('categoria') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categoria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telefone" class="form-label">Telefone *</label>
                                        <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                               id="telefone" name="telefone" value="{{ old('telefone') }}" required>
                                        @error('telefone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Senha *</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirmar Senha *</label>
                                        <input type="password" class="form-control"
                                               id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="endereco" class="form-label">Endereço *</label>
                                        <input type="text" class="form-control @error('endereco') is-invalid @enderror"
                                               id="endereco" name="endereco" value="{{ old('endereco') }}" required>
                                        @error('endereco')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="numero" class="form-label">Número *</label>
                                        <input type="text" class="form-control @error('numero') is-invalid @enderror"
                                               id="numero" name="numero" value="{{ old('numero') }}" required>
                                        @error('numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="bairro" class="form-label">Bairro *</label>
                                        <input type="text" class="form-control @error('bairro') is-invalid @enderror"
                                               id="bairro" name="bairro" value="{{ old('bairro') }}" required>
                                        @error('bairro')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cidade" class="form-label">Cidade *</label>
                                        <input type="text" class="form-control @error('cidade') is-invalid @enderror"
                                               id="cidade" name="cidade" value="{{ old('cidade') }}" required>
                                        @error('cidade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado *</label>
                                        <input type="text" class="form-control @error('estado') is-invalid @enderror"
                                               id="estado" name="estado" value="{{ old('estado') }}" maxlength="2" required>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="cep" class="form-label">CEP *</label>
                                        <input type="text" class="form-control @error('cep') is-invalid @enderror"
                                               id="cep" name="cep" value="{{ old('cep') }}" required>
                                        @error('cep')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="taxa_multiplic" class="form-label">Taxa Multiplic (%) *</label>
                                        <input type="number" step="0.01" class="form-control @error('taxa_multiplic') is-invalid @enderror"
                                               id="taxa_multiplic" name="taxa_multiplic" value="{{ old('taxa_multiplic') }}" required>
                                        @error('taxa_multiplic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="taxa_estabelecimento" class="form-label">Taxa Estabelecimento (%) *</label>
                                        <input type="number" step="0.01" class="form-control @error('taxa_estabelecimento') is-invalid @enderror"
                                               id="taxa_estabelecimento" name="taxa_estabelecimento" value="{{ old('taxa_estabelecimento') }}" required>
                                        @error('taxa_estabelecimento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">A soma das duas taxas deve ser 100%</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.estabelecimentos.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Salvar</button>
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
