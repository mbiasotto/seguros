@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Exemplos de Modais</h1>
            <p class="lead">Demonstração dos diferentes tipos de modais disponíveis no sistema.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Modal Básico</h5>
                </div>
                <div class="card-body">
                    <p>Um modal simples com título, corpo e rodapé.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        Abrir Modal Básico
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Modal de Confirmação</h5>
                </div>
                <div class="card-body">
                    <p>Um modal para confirmar uma ação do usuário.</p>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        Abrir Modal de Confirmação
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Modal de Exclusão</h5>
                </div>
                <div class="card-body">
                    <p>Um modal para confirmar a exclusão de um item.</p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Abrir Modal de Exclusão
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Modal Grande</h5>
                </div>
                <div class="card-body">
                    <p>Um modal com tamanho grande para exibir mais conteúdo.</p>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#largeModal">
                        Abrir Modal Grande
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Modal com Atributos de Dados</h5>
                </div>
                <div class="card-body">
                    <p>Botões que abrem modais usando atributos de dados.</p>
                    <button
                        class="btn btn-danger mb-2"
                        data-delete-url="#"
                        data-delete-title="Excluir Item"
                        data-delete-message="Tem certeza que deseja excluir este item permanentemente?"
                        data-delete-confirm="Sim, Excluir"
                        data-delete-cancel="Não, Cancelar"
                    >
                        Excluir com Atributos
                    </button>

                    <button
                        class="btn btn-warning"
                        data-confirm-action="#"
                        data-confirm-title="Arquivar Item"
                        data-confirm-message="Tem certeza que deseja arquivar este item?"
                        data-confirm-confirm="Sim, Arquivar"
                        data-confirm-cancel="Não, Cancelar"
                        data-confirm-type="warning"
                    >
                        Confirmar com Atributos
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Modal Criado via JavaScript</h5>
                </div>
                <div class="card-body">
                    <p>Um modal criado dinâmicamente usando JavaScript.</p>
                    <button type="button" class="btn btn-success" id="createJsModal">
                        Criar Modal com JavaScript
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Básico -->
<x-modal id="basicModal" title="Título do Modal Básico">
    <p>Este é um exemplo de modal básico.</p>
    <p>Você pode colocar qualquer conteúdo aqui, como textos, imagens, formulários, etc.</p>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Salvar</button>
    </x-slot>
</x-modal>

<!-- Modal de Confirmação -->
<x-confirm-modal
    id="confirmModal"
    title="Confirmar Ação"
    message="Tem certeza que deseja realizar esta ação?"
    confirmText="Confirmar"
    cancelText="Cancelar"
    type="warning"
    confirmAction="alert('Ação confirmada!')"
>
</x-confirm-modal>

<!-- Modal de Exclusão -->
<x-confirm-modal
    id="deleteModal"
    title="Excluir Item"
    message="Tem certeza que deseja excluir este item permanentemente?"
    confirmText="Sim, Excluir"
    cancelText="Não, Cancelar"
    type="danger"
    confirmAction="alert('Item excluído!')"
>
</x-confirm-modal>

<!-- Modal Grande -->
<x-modal id="largeModal" title="Modal Grande" size="modal-lg">
    <div class="row">
        <div class="col-md-6">
            <h4>Coluna 1</h4>
            <p>Este modal é grande o suficiente para conter várias colunas de conteúdo.</p>
            <p>Útil para formulários complexos, tabelas ou outros conteúdos que precisam de mais espaço.</p>
        </div>
        <div class="col-md-6">
            <h4>Coluna 2</h4>
            <p>A classe modal-lg aumenta a largura do modal para comportar mais conteúdo.</p>
            <p>O modal continua sendo responsivo e se ajustará a telas menores conforme necessário.</p>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Salvar</button>
    </x-slot>
</x-modal>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Botão para criar um modal dinamicamente com JavaScript
        document.getElementById('createJsModal').addEventListener('click', function() {
            ModernModal.create({
                id: 'dynamicJsModal',
                title: 'Modal Criado com JavaScript',
                content: `
                    <p>Este modal foi criado dinamicamente usando JavaScript!</p>
                    <div class="alert alert-success">
                        <strong>Vantagem:</strong> Não é necessário definir o HTML do modal antecipadamente.
                    </div>
                    <p>Perfeito para conteúdo gerado dinamicamente ou para ações que não são conhecidas previamente.</p>
                `,
                size: 'modal-lg',
                buttons: [
                    {
                        id: 'btnCancel',
                        text: 'Cancelar',
                        class: 'btn-secondary',
                        dismiss: true
                    },
                    {
                        id: 'btnSave',
                        text: 'Salvar',
                        class: 'btn-primary',
                        callback: function(e, modalInstance) {
                            alert('Botão salvar clicado!');
                            modalInstance.hide();
                        }
                    }
                ],
                onShow: function() {
                    console.log('Modal exibido!');
                }
            }).show();
        });
    });
</script>
@endsection
