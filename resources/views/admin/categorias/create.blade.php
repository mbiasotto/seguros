@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Nova Categoria</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categorias.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nome') is-invalid @enderror"
                                   id="nome"
                                   name="nome"
                                   value="{{ old('nome') }}"
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
                                      rows="3">{{ old('descricao') }}</textarea>
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
                                       {{ old('ativo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Categoria ativa
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Criar Categoria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
