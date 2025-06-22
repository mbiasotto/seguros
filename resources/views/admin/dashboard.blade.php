@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<!-- CSS específico do dashboard -->
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/dashboard.css') }}">
@endpush

@section('content')

    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div><!-- Espaço para botões caso necessário no futuro --></div>
    </div>
    <p class="text-muted">Bem-vindo ao painel administrativo</p>

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

        <!-- Total Vendors Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon icon-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle mb-1 text-muted">Total Clientes</h6>
                            <h2 class="card-title mb-0">{{ $totalUsers }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon icon-info">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle mb-1 text-muted">Total Categorias</h6>
                            <h2 class="card-title mb-0">{{ $totalCategories }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon icon-warning">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle mb-1 text-muted">Sistema Ativo</h6>
                            <h2 class="card-title mb-0"><i class="fas fa-check text-success"></i></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cadastros de Estabelecimentos por Mês/Ano</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="monthlyChart" data-chart="{{ json_encode($chartData ?? ['establishments' => []]) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Clientes por Mês/Ano</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="usersChart" data-chart="{{ json_encode(['users' => $chartData['users'] ?? []]) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Establishments -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Estabelecimentos Recentes</h5>
                    <a href="{{ route('admin.establishments.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentEstablishments as $establishment)
                            <div class="list-group-item px-3 py-3 recent-list-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $establishment->nome_fantasia ?? $establishment->razao_social }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $establishment->categoria->nome ?? 'N/A' }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">{{ $establishment->created_at->format('d/m/Y') }}</small>
                                        <a href="{{ route('admin.establishments.show', $establishment) }}" class="btn action-btn">
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

        <!-- Recent Users -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Clientes Recentes</h5>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @php
                            $recentUsers = \App\Models\Cliente::orderByDesc('created_at')->limit(5)->get();
                        @endphp

                        @if($recentUsers->count() > 0)
                            @foreach($recentUsers as $user)
                                <div class="list-group-item px-3 py-3 recent-list-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $user->nome }}</h6>
                                            <small class="text-muted">
                                                @if($user->status === 'ativo')
                                                    <span class="badge bg-success">Ativo</span>
                                                @elseif($user->status === 'pendente')
                                                    <span class="badge bg-warning text-dark">Pendente</span>
                                                @else
                                                    <span class="badge bg-danger">Bloqueado</span>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block">{{ $user->created_at->format('d/m/Y') }}</small>
                                            <a href="{{ route('admin.clientes.edit', $user) }}" class="btn action-btn">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Nenhum cliente encontrado</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<!-- Chart.js é carregado anteriormente pelo layout principal -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('assets/admin/js/pages/dashboard.js') }}"></script>
@endpush
