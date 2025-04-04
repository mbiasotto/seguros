@extends('vendor.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4 mb-4">
        <!-- Total Establishments Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-primary bg-opacity-10">
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

        <!-- Active Establishments Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-success bg-opacity-10">
                            <i class="fas fa-check-circle text-success"></i>
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Cadastros por Mês/Ano</h5>

                    <div style="position: relative; height: 400px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Establishments -->
        <div class="col-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Estabelecimentos Recentes</h5>
                    <div class="list-group list-group-flush">
                        @foreach($recentEstablishments as $establishment)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $establishment->nome }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $establishment->cidade }}/{{ $establishment->estado }}
                                        </small>
                                    </div>
                                    <small class="text-muted">
                                        {{ $establishment->created_at->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
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
