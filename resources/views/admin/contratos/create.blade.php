@extends('admin.layouts.app')

@section('title', 'Novo Contrato')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Novo Contrato</h1>
        @include('admin.components.back-button', ['route' => route('admin.contratos.index')])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.contratos.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">Dados do Contrato</h5>
                            </div>

                                                <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usuario_id" class="form-label">Cliente <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('usuario_id') is-invalid @enderror" id="usuario_id" name="usuario_id" required>
                                        <option value="">Selecione um cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('usuario_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nome }} - {{ $cliente->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('usuario_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="site" {{ old('tipo') == 'site' ? 'selected' : '' }}>Site</option>
                                        <option value="avulso" {{ old('tipo') == 'avulso' ? 'selected' : '' }}>Avulso</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                                                <div class="col-12">
                                <div class="mb-3">
                                    <label for="documento_identidade" class="form-label">Documento de Identidade <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control form-control-lg @error('documento_identidade') is-invalid @enderror"
                                           id="documento_identidade" name="documento_identidade"
                                           accept="image/*,.pdf" required>
                                    <small class="form-text text-muted text-sm">Formatos aceitos: JPG, PNG, PDF. Tamanho máximo: 10MB</small>
                                    @error('documento_identidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="score_inicial" class="form-label">Score Inicial</label>
                                    <input type="number" class="form-control form-control-lg @error('score_inicial') is-invalid @enderror"
                                           id="score_inicial" name="score_inicial" value="{{ old('score_inicial') }}"
                                           min="0" max="1000">
                                    <small class="form-text text-muted text-sm">Deixe vazio para consultar automaticamente</small>
                                    @error('score_inicial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="limite_inicial" class="form-label">Limite Inicial</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control form-control-lg @error('limite_inicial') is-invalid @enderror"
                                               id="limite_inicial" name="limite_inicial" value="{{ old('limite_inicial') }}"
                                               min="0" step="0.01">
                                    </div>
                                    <small class="form-text text-muted text-sm">Deixe vazio para calcular automaticamente pelo score</small>
                                    @error('limite_inicial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                                                <div class="col-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('admin.contratos.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-times me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-save me-2"></i> Cadastrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card de Informações -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">Informações Importantes</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">Como funciona:</h6>
                            <ul class="mb-0">
                                <li>Selecione o cliente que receberá o contrato</li>
                                <li>Escolha o tipo (Site ou Avulso)</li>
                                <li>Faça upload do documento de identidade</li>
                                <li>O sistema gerará automaticamente o número do contrato</li>
                                <li>O limite será calculado baseado no score</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="score-reference">
                            <h6 class="fw-bold">Referência de Score:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Score</th>
                                            <th>Limite</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0-300</td>
                                            <td class="text-success fw-bold">R$ 200,00</td>
                                        </tr>
                                        <tr>
                                            <td>301-500</td>
                                            <td class="text-success fw-bold">R$ 300,00</td>
                                        </tr>
                                        <tr>
                                            <td>501-700</td>
                                            <td class="text-success fw-bold">R$ 500,00</td>
                                        </tr>
                                        <tr>
                                            <td>701-900</td>
                                            <td class="text-success fw-bold">R$ 700,00</td>
                                        </tr>
                                        <tr>
                                            <td>901+</td>
                                            <td class="text-success fw-bold">R$ 1.000,00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
