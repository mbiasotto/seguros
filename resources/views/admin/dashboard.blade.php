@extends('admin.layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/components/charts.css') }}">
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
    }
    .document-alerts a {
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted">Bem-vindo ao painel administrativo</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Total Establishments Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fas fa-store text-primary"></i>
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
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="fas fa-users text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle mb-1 text-muted">Total Vendedores</h6>
                            <h2 class="card-title mb-0">{{ $totalVendors }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Codes Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="fas fa-qrcode text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle mb-1 text-muted">QR Codes Ativos</h6>
                            <h2 class="card-title mb-0">{{ \App\Models\QrCode::where('active', true)->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Documents Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <a href="{{ route('admin.establishments.documents.pending') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning bg-opacity-10">
                                <i class="fas fa-file-alt text-warning"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="card-subtitle mb-1 text-muted">Documentos Pendentes</h6>
                                <h2 class="card-title mb-0">{{ \App\Models\EstablishmentOnboarding::whereNotNull('document_path')->where('document_approved', false)->whereNull('document_approved_at')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cadastros por Mês/Ano</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active">Estabelecimentos</button>
                        <button type="button" class="btn btn-sm btn-outline-primary">Documentos</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Status dos Documentos</h5>
                </div>
                <div class="card-body document-alerts">
                    <a href="{{ route('admin.establishments.documents.pending') }}">
                        <div class="alert alert-warning d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Pendentes</h6>
                                <p class="mb-0">
                                    {{ \App\Models\EstablishmentOnboarding::whereNotNull('document_path')->where('document_approved', false)->whereNull('document_approved_at')->count() }} documento(s) aguardando aprovação
                                </p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.establishments.documents.approved') }}">
                        <div class="alert alert-success d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Aprovados</h6>
                                <p class="mb-0">
                                    {{ \App\Models\EstablishmentOnboarding::whereNotNull('document_path')->where('document_approved', true)->count() }} documento(s) aprovados
                                </p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.establishments.documents.rejected') }}">
                        <div class="alert alert-danger d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Rejeitados</h6>
                                <p class="mb-0">
                                    {{ \App\Models\EstablishmentOnboarding::whereNotNull('document_path')->where('document_approved', false)->whereNotNull('document_approved_at')->count() }} documento(s) rejeitados
                                </p>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
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
                            <div class="list-group-item px-3 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $establishment->nome }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $establishment->vendor->nome ?? 'N/A' }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">{{ $establishment->created_at->format('d/m/Y') }}</small>
                                        <a href="{{ route('admin.establishments.show', $establishment) }}" class="btn btn-sm btn-outline-secondary mt-1">
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

        <!-- Recent Documents -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Documentos Recentes</h5>
                    <a href="{{ route('admin.establishments.documents.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @php
                            $recentDocuments = \App\Models\EstablishmentOnboarding::whereNotNull('document_path')
                                ->with('establishment')
                                ->orderByDesc('updated_at')
                                ->limit(5)
                                ->get();
                        @endphp

                        @if($recentDocuments->count() > 0)
                            @foreach($recentDocuments as $document)
                                <div class="list-group-item px-3 py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $document->establishment->nome }}</h6>
                                            <small class="text-muted">
                                                @if($document->document_approved && $document->document_approved_at)
                                                    <span class="badge bg-success">Aprovado</span>
                                                @elseif(!$document->document_approved && $document->document_approved_at)
                                                    <span class="badge bg-danger">Rejeitado</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pendente</span>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block">{{ $document->updated_at->format('d/m/Y') }}</small>
                                            <a href="{{ route('admin.establishments.documents.show', $document) }}" class="btn btn-sm btn-outline-secondary mt-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="list-group-item py-4 text-center">
                                <p class="mb-0 text-muted">Nenhum documento encontrado</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('monthlyChart');
        if (!canvas) {
            console.error("Elemento 'monthlyChart' não encontrado!");
            return;
        }

        const ctx = canvas.getContext('2d');
        const monthlyData = @json($monthlyData);
        console.log("monthlyData:", monthlyData);

        const months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        // Define o período de Março/2024 até Fevereiro/2025
        const monthsOrder = [
            'Março/2024', 'Abril/2024', 'Maio/2024', 'Junho/2024',
            'Julho/2024', 'Agosto/2024', 'Setembro/2024', 'Outubro/2024',
            'Novembro/2024', 'Dezembro/2024', 'Janeiro/2025', 'Fevereiro/2025'
        ];

        // Mapeia os valores mensais para o período específico
        const monthlyValues = monthsOrder.map(monthYear => {
            const [month, year] = monthYear.split('/');
            const monthIndex = months.indexOf(month);
            return monthlyData[monthIndex + 1] || 0;
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthsOrder,
                datasets: [{
                    label: 'Estabelecimentos Cadastrados',
                    data: monthlyValues,
                    borderColor: '#1D40AE',
                    backgroundColor: 'rgba(29, 64, 174, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#1D40AE',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
