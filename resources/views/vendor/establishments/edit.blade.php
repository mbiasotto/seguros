@extends('vendor.layouts.app')

@section('title', 'Editar Estabelecimento')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Editar Estabelecimento</h4>
                    <a href="{{ route('vendor.establishments.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('vendor.establishments.update', $establishment) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nome" class="form-label">Nome do Estabelecimento</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $establishment->nome) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco', $establishment->endereco) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade', $establishment->cidade) }}" required>
                        </div>

                        <div class="col-md-2">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" maxlength="2" value="{{ old('estado', $establishment->estado) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep', $establishment->cep) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $establishment->telefone) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao', $establishment->descricao) }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" {{ old('ativo', $establishment->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">Estabelecimento Ativo</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
