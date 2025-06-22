@extends('admin.layouts.app')

@section('title', 'Relatórios Gerais')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/reports.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Relatórios Gerais</h1>
    <div>
        <button class="btn btn-outline-primary" onclick="window.print()">
            <i class="fas fa-print me-2"></i>
            Imprimir
        </button>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Estatísticas de Usuários -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Total de Usuários</h6>
                        <h2 class="card-title mb-0">{{ $stats['usuarios_total'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Usuários Ativos</h6>
                        <h2 class="card-title mb-0">{{ $stats['usuarios_ativos'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Usuários Bloqueados</h6>
                        <h2 class="card-title mb-0">{{ $stats['usuarios_bloqueados'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-info">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Estabelecimentos</h6>
                        <h2 class="card-title mb-0">{{ $stats['estabelecimentos_total'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- QR Codes Stats -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-secondary">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">QR Codes Total</h6>
                        <h2 class="card-title mb-0">{{ $stats['qr_codes_total'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-success">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">QR Codes Ativos</h6>
                        <h2 class="card-title mb-0">{{ $stats['qr_codes_ativos'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Acessos Total</h6>
                        <h2 class="card-title mb-0">{{ $stats['acessos_total'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Acessos Hoje</h6>
                        <h2 class="card-title mb-0">{{ $stats['acessos_hoje'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Ações Rápidas -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Relatórios Específicos</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.relatorios.usuarios') }}" class="btn btn-outline-primary d-flex align-items-center">
                        <i class="fas fa-users me-3"></i>
                        <div>
                            <strong>Relatório de Usuários</strong>
                            <small class="d-block text-muted">Detalhes completos dos usuários</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.relatorios.estabelecimentos') }}" class="btn btn-outline-success d-flex align-items-center">
                        <i class="fas fa-store me-3"></i>
                        <div>
                            <strong>Relatório de Estabelecimentos</strong>
                            <small class="d-block text-muted">Detalhes completos dos estabelecimentos</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.relatorios.faturamento') }}" class="btn btn-outline-warning d-flex align-items-center">
                        <i class="fas fa-dollar-sign me-3"></i>
                        <div>
                            <strong>Relatório de Faturamento</strong>
                            <small class="d-block text-muted">Análise financeira e comissões</small>
                        </div>
                    </a>
                    <a href="{{ route('admin.qr-codes.acessos') }}" class="btn btn-outline-info d-flex align-items-center">
                        <i class="fas fa-chart-line me-3"></i>
                        <div>
                            <strong>Acessos aos QR Codes</strong>
                            <small class="d-block text-muted">Análise detalhada de acessos</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumo do Sistema -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Resumo do Sistema</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $stats['estabelecimentos_ativos'] }}</h3>
                            <small class="text-muted">Estabelecimentos Ativos</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="text-center">
                            <h3 class="text-success">{{ $stats['acessos_mes'] }}</h3>
                            <small class="text-muted">Acessos Este Mês</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="text-center">
                            @php
                                $percentualAtivos = $stats['usuarios_total'] > 0 ? ($stats['usuarios_ativos'] / $stats['usuarios_total']) * 100 : 0;
                            @endphp
                            <h3 class="text-info">{{ number_format($percentualAtivos, 1) }}%</h3>
                            <small class="text-muted">Usuários Ativos</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="text-center">
                            @php
                                $percentualQrAtivos = $stats['qr_codes_total'] > 0 ? ($stats['qr_codes_ativos'] / $stats['qr_codes_total']) * 100 : 0;
                            @endphp
                            <h3 class="text-warning">{{ number_format($percentualQrAtivos, 1) }}%</h3>
                            <small class="text-muted">QR Codes Ativos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
