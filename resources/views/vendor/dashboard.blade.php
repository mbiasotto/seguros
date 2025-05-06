@extends('vendor.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/dashboard.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div><!-- Espaço para botões caso necessário no futuro --></div>
</div>
<p class="text-muted">Bem-vindo ao painel do vendedor</p>

<div class="row g-4 mb-4">
    <!-- Total Establishments Card -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Total Estabelecimentos</h6>
                        <h2 class="card-title mb-0">{{ $totalEstablishments }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Establishments Card -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Estabelecimentos Ativos</h6>
                        <h2 class="card-title mb-0">{{ $activeEstablishments }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Monthly Registrations Chart -->
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Cadastros por Mês/Ano</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="monthlyChart" data-chart="{{ json_encode($monthlyData) }}"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Establishments -->
    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Estabelecimentos Recentes</h5>
                <a href="{{ route('vendor.establishments.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($recentEstablishments as $establishment)
                        <div class="list-group-item px-3 py-3 recent-list-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $establishment->nome }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $establishment->cidade }}/{{ $establishment->estado }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">{{ $establishment->created_at->format('d/m/Y') }}</small>
                                    <a href="{{ route('vendor.establishments.edit', $establishment) }}" class="btn action-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('assets/admin/js/pages/dashboard.js') }}"></script>
@endpush
