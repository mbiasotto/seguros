@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Editar Categoria: {{ $categoria->nome }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nome') is-invalid @enderror"
                                   id="nome"
                                   name="nome"
                                   value="{{ old('nome', $categoria->nome) }}"
                                   required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror"
                                      id="descricao"
                                      name="descricao"
                                      rows="3">{{ old('descricao', $categoria->descricao) }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox"
                                       class="form-check-input"
                                       id="ativo"
                                       name="ativo"
                                       value="1"
                                       {{ old('ativo', $categoria->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Categoria ativa
                                </label>
                            </div>
                        </div>

                        @if($categoria->estabelecimentos_count > 0)
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Esta categoria possui {{ $categoria->estabelecimentos_count }} estabelecimentos vinculados.
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Atualizar Categoria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
