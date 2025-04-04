# Componente de Modal Moderno

Este componente fornece uma interface moderna e reutilizável para modais em todo o sistema Segura Essa.

## Arquivos Disponíveis

- `public/css/components/modal.css`: Estilos do modal
- `public/js/modal.js`: Funções JavaScript para o modal
- `resources/views/components/modal.blade.php`: Componente Blade para modal genérico
- `resources/views/components/confirm-modal.blade.php`: Componente Blade para modal de confirmação

## Como Usar

### Modal Básico

```html
<x-modal id="exemploModal" title="Título do Modal" size="modal-lg">
    <p>Conteúdo do modal aqui.</p>
    
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Salvar</button>
    </x-slot>
</x-modal>

<!-- Botão para abrir o modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exemploModal">
    Abrir Modal
</button>
```

### Modal de Confirmação

```html
<x-confirm-modal 
    id="confirmarExclusao"
    title="Excluir Item" 
    message="Tem certeza que deseja excluir este item?" 
    confirmText="Excluir" 
    cancelText="Cancelar"
    type="danger"
    confirmRoute="{{ route('item.destroy', $item) }}"
    method="DELETE"
>
    <!-- Campos adicionais para o form, se necessário -->
    <input type="hidden" name="extra_param" value="valor">
</x-confirm-modal>

<!-- Botão para abrir o modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarExclusao">
    Excluir
</button>
```

### Criação Dinâmica com JavaScript

```javascript
// Criar um modal usando a classe ModernModal
const modal = ModernModal.create({
    id: 'dynamicModal',
    title: 'Modal Dinâmico',
    content: '<p>Este modal foi criado dinamicamente!</p>',
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
                console.log('Botão salvar clicado!');
                modalInstance.hide();
            }
        }
    ]
});

// Exibir o modal
modal.show();
```

### Botões de Exclusão Automáticos

Para botões de exclusão, adicione os atributos de dados:

```html
<button 
    class="btn btn-danger"
    data-delete-url="{{ route('item.destroy', $item) }}"
    data-delete-title="Excluir Item"
    data-delete-message="Tem certeza que deseja excluir este item permanentemente?"
    data-delete-confirm="Sim, Excluir"
    data-delete-cancel="Não, Cancelar"
>
    Excluir
</button>
```

### Botões de Confirmação Genéricos

Para botões de confirmação genéricos:

```html
<button 
    class="btn btn-warning"
    data-confirm-action="{{ route('item.archive', $item) }}"
    data-confirm-title="Arquivar Item"
    data-confirm-message="Tem certeza que deseja arquivar este item?"
    data-confirm-confirm="Sim, Arquivar"
    data-confirm-cancel="Não, Cancelar"
    data-confirm-type="warning"
>
    Arquivar
</button>
```

## Parâmetros

### Modal Básico

| Parâmetro | Tipo | Padrão | Descrição |
|-----------|------|--------|-----------|
| id | string | 'modal' | ID único do modal |
| title | string | '' | Título do modal |
| size | string | '' | Tamanho do modal: modal-sm, modal-lg, modal-xl |
| closeButton | boolean | true | Exibir botão de fechar no cabeçalho |
| staticBackdrop | boolean | false | Impedir fechamento ao clicar fora |

### Modal de Confirmação

| Parâmetro | Tipo | Padrão | Descrição |
|-----------|------|--------|-----------|
| id | string | 'confirmModal' | ID único do modal |
| title | string | 'Confirmar ação' | Título do modal |
| message | string | 'Tem certeza que deseja continuar?' | Mensagem do modal |
| confirmText | string | 'Confirmar' | Texto do botão de confirmação |
| cancelText | string | 'Cancelar' | Texto do botão de cancelamento |
| type | string | 'warning' | Tipo do modal: warning, danger, success |
| confirmRoute | string | '' | Rota para submeter o formulário |
| confirmAction | string | '' | Ação JS para o botão de confirmação |
| method | string | 'POST' | Método HTTP para o formulário |
