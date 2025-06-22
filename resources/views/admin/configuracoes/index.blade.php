@extends('admin.layouts.app')

@section('title', 'Configurações do Sistema')

@section('content')
<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">Configurações do Sistema</h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.configuracoes.store') }}" method="POST" class="needs-validation" novalidate>
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

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @foreach($configuracoes as $grupo => $configsGrupo)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold text-lg border-bottom pb-2 mb-4">
                                    <i class="fas fa-{{ $grupo === 'CPFL' ? 'plug' : ($grupo === 'Sistema de Crédito' ? 'credit-card' : ($grupo === 'Score e Limites' ? 'chart-line' : 'wrench')) }} me-2"></i>
                                    {{ $grupo }}
                                </h5>
                            </div>

                            @foreach($configsGrupo as $config)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="config_{{ $config->id }}" class="form-label">
                                        {{ getNomeAmigavel($config->chave) }}
                                        <span class="text-danger">*</span>
                                    </label>



                                    @if(str_contains($config->chave, 'valor_') || str_contains($config->chave, 'juros'))
                                        <div class="input-group">
                                            @if(str_contains($config->chave, 'valor_'))
                                                <span class="input-group-text">R$</span>
                                            @else
                                                <span class="input-group-text">%</span>
                                            @endif
                                            <input type="{{ getTipoInput($config->chave) }}"
                                                   class="form-control form-control-lg @error('config_'.$config->id) is-invalid @enderror"
                                                   id="config_{{ $config->id }}"
                                                   name="config_{{ $config->id }}"
                                                   value="{{ old('config_'.$config->id, $config->valor) }}"
                                                   step="{{ str_contains($config->chave, 'valor_') ? '0.01' : '0.01' }}"
                                                   required>
                                        </div>
                                    @else
                                        <input type="{{ getTipoInput($config->chave) }}"
                                               class="form-control form-control-lg @error('config_'.$config->id) is-invalid @enderror"
                                               id="config_{{ $config->id }}"
                                               name="config_{{ $config->id }}"
                                               value="{{ old('config_'.$config->id, $config->valor) }}"
                                               required>
                                    @endif

                                    @if($config->descricao)
                                        <small class="form-text text-muted">{{ $config->descricao }}</small>
                                    @endif

                                    @error('config_'.$config->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach

                        <div class="col-12">
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class="fas fa-save me-2"></i> Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@php
    function getNomeAmigavel($chave) {
        $nomes = [
            'valor_mensalidade_cpfl' => 'Valor Mensalidade CPFL',
            'juros_credito_rotativo' => 'Juros Crédito Rotativo',
            'prazo_revisao_score_dias' => 'Prazo Revisão Score (dias)',
        ];

        return $nomes[$chave] ?? ucwords(str_replace('_', ' ', $chave));
    }

    function getTipoInput($chave) {
        if (str_contains($chave, 'valor_') || str_contains($chave, 'juros')) {
            return 'number';
        }
        if (str_contains($chave, 'dias') || str_contains($chave, 'prazo')) {
            return 'number';
        }
        return 'text';
    }
@endphp
