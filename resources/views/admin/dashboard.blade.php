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
                        <div class="stat-icon icon-info">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle mb-1 text-muted">Total de Acessos QR Code</h6>
                            <h2 class="card-title mb-0">{{ \App\Models\QrCodeAccessLog::count() }}</h2>
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
                            <div class="stat-icon icon-warning">
                                <i class="fas fa-file-alt"></i>
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
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cadastros de Estabelecimentos por Mês/Ano</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="monthlyChart" data-chart="{{ json_encode($chartData ?? ['establishments' => [], 'documents' => [], 'qr_logs' => []]) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Acessos QR Code por Mês/Ano</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        {{-- The qrLogsChart will also use the main chartData from monthlyChart for its data source in JS --}}
                        <canvas id="qrLogsChart" data-chart="{{ json_encode($chartData ?? ['establishments' => [], 'documents' => [], 'qr_logs' => []]) }}"></canvas>
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
                                        <h6 class="mb-1">{{ $establishment->nome }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $establishment->vendor->nome ?? 'N/A' }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">{{ $establishment->created_at->format('d/m/Y') }}</small>
                                        <a href="{{ route('admin.establishments.edit', $establishment) }}" class="btn action-btn">
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
                                <div class="list-group-item px-3 py-3 recent-list-item">
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
                                            <a href="{{ route('admin.establishments.documents.show', $document) }}" class="btn action-btn">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Nenhum documento encontrado</p>
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
