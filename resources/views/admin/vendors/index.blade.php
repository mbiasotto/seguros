@extends('admin.layouts.app')

@section('title', 'Vendedores')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/data-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
@endpush

@section('content')
<div class="data-list-header">
    <h1 class="h3 mb-0">Vendedores</h1>
    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Novo Vendedor</span>
    </a>
</div>

@if($vendors->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body empty-state text-center py-5">
            <div class="empty-state-icon mb-4 bg-light rounded-circle p-4 d-inline-flex justify-content-center align-items-center" style="width: 120px; height: 120px;">
                <i class="fas fa-users text-primary fa-3x"></i>
            </div>
            <h3 class="fw-bold mb-3">Nenhum vendedor cadastrado</h3>
            <p class="text-muted mb-4 col-md-8 mx-auto">Você ainda não possui vendedores cadastrados no sistema. Adicione seu primeiro vendedor para começar a gerenciar sua equipe de vendas.</p>
            <div class="mt-4">
                <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-plus me-2"></i>
                    <span>Adicionar Vendedor</span>
                </a>
            </div>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cidade/Estado</th>
                        <th>Status</th>
                        <th width="120">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->nome }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->telefone }}</td>
                            <td>{{ $vendor->cidade }}/{{ $vendor->estado }}</td>
                            <td>
                                @if($vendor->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este vendedor?')" title="Excluir">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($vendors->links))
    <div class="mt-4">
        {{ $vendors->links() }}
    </div>
    @endif
@endif
@endsection
