@extends('admin.layouts.app')

@section('title', 'Usuários')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/pages/list.css') }}">
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Usuários</h1>
    <div>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Novo Usuário
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Limite Total</th>
                        <th>Limite Disponível</th>
                        <th>Criado em</th>
                        <th width="120">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->cpf_formatado }}</td>
                            <td>{{ $usuario->nome }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if($usuario->status === 'ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @elseif($usuario->status === 'bloqueado')
                                    <span class="badge bg-danger">Bloqueado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pendente</span>
                                @endif
                            </td>
                            <td>R$ {{ number_format($usuario->limite_total, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($usuario->limite_disponivel, 2, ',', '.') }}</td>
                            <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.usuarios.show', $usuario) }}"
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                       class="btn btn-outline-secondary"
                                       data-bs-toggle="tooltip"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $usuario->id }}"
                                            data-bs-toggle="tooltip"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal de Confirmação de Exclusão -->
                                <div class="modal fade" id="deleteModal{{ $usuario->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar Exclusão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tem certeza que deseja excluir o usuário <strong>{{ $usuario->nome }}</strong>?</p>
                                                <p class="text-muted">Esta ação não pode ser desfeita.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Nenhum usuário encontrado</h5>
                                    <p class="text-muted">Clique em "Novo Usuário" para cadastrar o primeiro usuário.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usuarios->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
