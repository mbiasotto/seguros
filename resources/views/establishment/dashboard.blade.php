@extends('establishment.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/dashboard.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div><!-- Espaço para botões caso necessário no futuro --></div>
</div>
<p class="text-muted">Bem-vindo à sua área, {{ $establishment->nome }}</p>

<div class="row g-4 mb-4">
    <!-- Total QR Codes Card -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-primary">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">QR Codes Vinculados</h6>
                        <h2 class="card-title mb-0">{{ $totalQrCodes }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Accesses Card -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-success">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Total de Acessos</h6>
                        <h2 class="card-title mb-0">{{ $totalQrCodeAccesses }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Accesses Card -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-info">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Acessos Hoje</h6>
                        <h2 class="card-title mb-0">{{ $accessesToday }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- This Week's Accesses Card -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="card-subtitle mb-1 text-muted">Acessos esta Semana</h6>
                        <h2 class="card-title mb-0">{{ $accessesThisWeek }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Monthly Accesses Chart -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Acessos por Mês (Últimos 12 meses)</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="monthlyAccessesChart" data-chart="{{ json_encode($monthlyAccesses ?? []) }}"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- QR Code Statistics -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Estatísticas por QR Code</h5>
            </div>
            <div class="card-body p-0">
                @if(count($qrCodeStats) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>QR Code</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Hoje</th>
                                    <th class="text-center">Esta Semana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($qrCodeStats as $stat)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-qrcode me-2 text-primary"></i>
                                                <div>
                                                    <h6 class="mb-0">{{ $stat['qr_code']->title ?? 'QR Code #' . $stat['qr_code']->id }}</h6>
                                                    @if($stat['qr_code']->description)
                                                        <small class="text-muted">{{ Str::limit($stat['qr_code']->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $stat['total_accesses'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $stat['accesses_today'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $stat['accesses_this_week'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-qrcode fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Nenhum QR Code vinculado</h5>
                        <p class="text-muted">Entre em contato com seu vendedor para vincular QR Codes.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Accesses -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Acessos Recentes</h5>
            </div>
            <div class="card-body p-0">
                @if(count($recentAccesses) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentAccesses as $access)
                            <div class="list-group-item px-3 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 small">{{ $access->qrCode->title ?? 'QR Code #' . $access->qrCode->id }}</h6>
                                        <small class="text-muted">{{ $access->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <i class="fas fa-eye text-primary"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-clock fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Nenhum acesso recente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Accesses Chart
    const monthlyCtx = document.getElementById('monthlyAccessesChart');
    if (monthlyCtx) {
        const monthlyData = JSON.parse(monthlyCtx.dataset.chart);

        // Generate last 12 months labels
        const labels = [];
        const currentDate = new Date();
        for (let i = 11; i >= 0; i--) {
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
            labels.push(date.toLocaleDateString('pt-BR', { month: 'short', year: 'numeric' }));
        }

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Acessos',
                    data: monthlyData,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
@endpush
