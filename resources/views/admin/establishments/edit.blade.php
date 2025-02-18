@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Editar Estabelecimento
        </div>
        <div class="card-body">
            <form action="{{ route('admin.establishments.update', $establishment) }}" method="POST">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" value="{{ old('nome', $establishment->nome) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="vendor_id" class="form-label">Vendedor</label>
                    <select name="vendor_id" id="vendor_id" class="form-select" required>
                        <option value="">Selecione um vendedor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id', $establishment->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" name="endereco" id="endereco" value="{{ old('endereco', $establishment->endereco) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $establishment->cidade) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" name="estado" id="estado" value="{{ old('estado', $establishment->estado) }}" maxlength="2" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" name="cep" id="cep" value="{{ old('cep', $establishment->cep) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea name="observacoes" id="observacoes" rows="3" class="form-control">{{ old('observacoes', $establishment->observacoes) }}</textarea>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="ativo" id="ativo" value="1" {{ old('ativo', $establishment->ativo) ? 'checked' : '' }} class="form-check-input">
                    <label class="form-check-label" for="ativo">Ativo</label>
                </div>

                <a href="{{ route('admin.establishments.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
        </div>
    </div>
</div>
@endsection
