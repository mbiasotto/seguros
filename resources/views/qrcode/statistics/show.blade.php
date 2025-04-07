@extends('admin.layouts.app')

@section('title', 'Estatísticas do QR Code #' . $qrCode->id)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<style>
    .stats-card {
        border-radius: var(--border-radius);
        background-color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: transform 0.2s ease-in-out;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .stats-value {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    .stats-label {
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .chart-container {
        height: 300px;
        margin-bottom: 2rem;
    }
    .table-container {
        overflow-x: auto;
    }
    .qr-info {
        background-color: #f8f9fa;
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .qr-info p {
        margin-bottom: 0.5rem;
    }
    .qr-info .badge {
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dados para o gráfico de acessos diários
        const dailyData = @json($dailyStats);
        const hourlyData = @json($hourlyStats);

        // Gráfico de acessos diários
        const dailyLabels = dailyData.map(item => item.date);
        const dailyValues = dailyData.map(item => item.total);

        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Acessos Diários',
                    data: dailyValues,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Acessos por Dia (Últimos 30 dias)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Gráfico de acessos por hora
        const hourlyLabels = hourlyData.map(item => `${parseInt(item.hour)}h`);
        const hourlyValues = hourlyData.map(item => item.total);

        const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: hourlyLabels,
                datasets: [{
                    label: 'Acessos por Hora',
                    data: hourlyValues,
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Acessos por Hora do Dia (Últimos 30 dias)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">Estatísticas do QR Code #{{ $qrCode->id }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.qr-codes.statistics.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span class="font-medium">Voltar para Estatísticas</span>
        </a>
        <a href="{{ route('admin.qr-codes.show', $qrCode->id) }}" class="btn btn-info d-flex align-items-center gap-2">
            <i class="fas fa-qrcode"></i>
            <span class="font-medium">Ver QR Code</span>
        </a>
    </div>
</div>

<!-- Informações do QR Code -->
<div class="qr-info">
    <h5 class="font-semibold mb-2">{{ $qrCode->title ?: 'QR Code sem título' }}</h5>
    <p><strong>Link:</strong> {{ $qrCode->link }}</p>
    @if($qrCode->description)
        <p><strong>Descrição:</strong> {{ $qrCode->description }}</p>
    @endif
    <p>
        <strong>Status:</strong>
        @if($qrCode->active)
            <span class="badge bg-success">Ativo</span>
        @else
            <span class="badge bg-danger">Inativo</span>
        @endif
    </p>
    @if($qrCode->establishments->count() > 0)
        <p>
            <strong>Estabelecimentos vinculados:</strong>
            @foreach($qrCode->establishments as $establishment)
                <span class="badge bg-info">{{ $establishment->name }}</span>
            @endforeach
        </p>
    @else
        <p><strong>Estabelecimentos vinculados:</strong> <span class="badge bg-secondary">Nenhum</span></p>
    @endif
    <p><strong>URL de Redirecionamento:</strong> <a href="{{ $qrCode->qr_code_url }}" target="_blank">{{ $qrCode->qr_code_url }}</a></p>
</div>

<!-- Resumo das Estatísticas -->
<div class="row">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value text-primary">{{ number_format($totalAccesses) }}</div>
            <div class="stats-label">Total de Acessos</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value text-danger">{{ number_format($lastDayAccesses) }}</div>
            <div class="stats-label">Últimas 24 Horas</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value text-success">{{ number_format($lastWeekAccesses) }}</div>
            <div class="stats-label">Últimos 7 Dias</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value text-info">{{ number_format($lastMonthAccesses) }}</div>
            <div class="stats-label">Últimos 30 Dias</div>
        </div>
    </div>
</div>

<!-- Gráficos de Estatísticas -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm mb-4 h-100">
            <div class="card-body">
                <h5 class="card-title">Acessos por Dia</h5>
                <div class="chart-container">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm mb-4 h-100">
            <div class="card-body">
                <h5 class="card-title">Acessos por Hora do Dia</h5>
                <div class="chart-container">
                    <canvas id="hourlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimos Acessos -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">Últimos Acessos</h5>
        <div class="table-container">
            <table class="table table-sm table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 180px;">Data e Hora</th>
                        <th style="width: 150px;">IP</th>
                        <th>Navegador</th>
                        <th style="width: 150px;">Referência</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAccesses as $access)
                        <tr>
                            <td class="font-medium">{{ $access->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $access->ip_address }}</td>
                            <td class="text-truncate" style="max-width: 300px;">
                                <small>{{ Str::limit($access->user_agent, 100) }}</small>
                            </td>
                            <td class="text-truncate" style="max-width: 150px;">
                                <small>{{ $access->referer ? Str::limit($access->referer, 30) : 'Direto' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-chart-bar text-muted fa-2x mb-3"></i>
                                    <p class="text-muted mb-0">Nenhum acesso registrado ainda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
