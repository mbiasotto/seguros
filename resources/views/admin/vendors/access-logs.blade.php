@extends('admin.layouts.app')

@section('title', 'Histórico de Acessos - ' . $vendor->nome)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold">Histórico de Acessos - {{ $vendor->nome }}</h2>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para a lista
                </a>
            </div>
        </div>
    </div>

@if($accessLogs->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-history text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhum acesso registrado</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Este vendedor ainda não realizou nenhum acesso ao sistema.</p>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Data/Hora</th>
                        <th>Endereço IP</th>
                        <th>Navegador/Dispositivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accessLogs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td>{{ $log->user_agent }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($accessLogs->links))
    <div class="mt-4">
        {{ $accessLogs->links() }}
    </div>
    @endif
@endif
</div>
@endsection