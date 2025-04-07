@extends('admin.layouts.app')

@section('title', 'Estatísticas de QR Codes')

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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dados para o gráfico de acessos diários
        const dailyData = @json($dailyStats);

        const labels = dailyData.map(item => item.date);
        const values = dailyData.map(item => item.total);

        const ctx = document.getElementById('dailyChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Acessos Diários',
                    data: values,
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
    });
</script>
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">Estatísticas de QR Codes</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.qr-codes.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span class="font-medium">Voltar</span>
        </a>
    </div>
</div>

<!-- Resumo das Estatísticas -->
<div class="row">
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-value text-primary">{{ number_format($totalAccesses) }}</div>
            <div class="stats-label">Total de Acessos</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-value text-success">{{ number_format($lastWeekAccesses) }}</div>
            <div class="stats-label">Acessos nos Últimos 7 Dias</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-value text-info">{{ number_format($lastMonthAccesses) }}</div>
            <div class="stats-label">Acessos nos Últimos 30 Dias</div>
        </div>
    </div>
</div>

<!-- Gráfico de Acessos -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title">Acessos por Dia</h5>
        <div class="chart-container">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>
</div>

<!-- QR Codes Mais Acessados -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">QR Codes Mais Acessados</h5>
        <div class="table-container">
            <table class="table table-sm table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Título</th>
                        <th style="width: 120px;">Total de Acessos</th>
                        <th style="width: 80px;">Status</th>
                        <th style="width: 100px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topQrCodes as $qrCode)
                        <tr>
                            <td class="text-muted">#{{ $qrCode->id }}</td>
                            <td class="font-medium">{{ $qrCode->title ?: 'Sem título' }}</td>
                            <td class="text-center">{{ number_format($qrCode->access_logs_count) }}</td>
                            <td>
                                @if($qrCode->active)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.qr-codes.statistics.show', $qrCode->id) }}" class="btn btn-primary" title="Ver Detalhes">
                                        <i class="fas fa-chart-line"></i>
                                    </a>
                                    <a href="{{ route('admin.qr-codes.show', $qrCode->id) }}" class="btn btn-info" title="Visualizar QR Code">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if($topQrCodes->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-chart-bar text-muted fa-2x mb-3"></i>
                                    <p class="text-muted mb-0">Nenhum QR Code foi acessado ainda.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
