# Padronização de Listagens
> Segura Essa - Sistema de Gestão de Estabelecimentos

Este documento contém diretrizes e padrões para implementação de listagens (index) de recursos no sistema administrativo. O objetivo é manter uma experiência de usuário consistente em todas as telas do sistema.

## Estrutura Padrão

Toda listagem deve seguir esta estrutura básica:

1. **Cabeçalho da Listagem**
2. **Filtros de Busca** (quando aplicável)
3. **Tabela de Dados** ou **Estado Vazio**
4. **Paginação** (quando aplicável)

## Arquivo de Referência

Use o arquivo `resources/views/admin/components/modelo-lista.blade.php` como base para criar novas listagens. Este arquivo contém comentários explicativos e exemplos de todos os componentes necessários.

## Diretrizes de Implementação

### Cabeçalho

```html
<div class="data-list-header">
    <h1 class="h3 mb-0">Título da Listagem</h1>
    <a href="#" class="btn btn-primary d-flex align-items-center gap-2" data-tooltip="Adicionar Novo">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>
```

### Filtros

```html
<div class="filter-container shadow-sm">
    <form action="#" method="GET" class="row g-3">
        <!-- Campos de filtro -->
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100" data-tooltip="Aplicar Filtros">Filtrar</button>
        </div>
    </form>
</div>
```

### Tabela de Dados

```html
<div class="card border-0 shadow-sm">
    <div class="table-container">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <!-- Colunas com títulos -->
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Linhas da tabela -->
            </tbody>
        </table>
    </div>
</div>
```

### Estado Vazio

```html
<div class="card border-0 shadow-sm">
    <div class="card-body empty-state text-center py-5">
        <div class="empty-state-icon mb-4 rounded-circle p-4 d-inline-flex justify-content-center align-items-center">
            <i class="fas fa-list fa-3x"></i>
        </div>
        <h3 class="fw-bold mb-3">Nenhum item encontrado</h3>
        <p class="text-muted mb-4 col-md-8 mx-auto">Mensagem explicativa...</p>
        <div class="mt-4">
            <a href="#" class="btn btn-primary d-flex align-items-center gap-2 mx-auto" style="width: fit-content;">
                <i class="fas fa-plus"></i>
                <span>Novo</span>
            </a>
        </div>
    </div>
</div>
```

### Paginação

```html
<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="pagination-info">
        Mostrando {{ $itens->firstItem() ?? 0 }} a {{ $itens->lastItem() ?? 0 }} de {{ $itens->total() }} resultados
    </div>
    {{ $itens->links() }}
</div>
```

## Componentes Específicos

### Badges de Status

Use a classe `status-badge` em vez de `badge bg-*` para manter consistência visual:

```html
<span class="status-badge ativo">Ativo</span>
<span class="status-badge inativo">Inativo</span>
```

### Botões de Ação

Os botões de ação devem estar dentro de um container com a classe `action-buttons` e devem usar `data-tooltip` para tooltips:

```html
<div class="action-buttons">
    <a href="#" class="btn action-btn" data-tooltip="Visualizar">
        <i class="fas fa-eye"></i>
    </a>
    <a href="#" class="btn action-btn" data-tooltip="Editar">
        <i class="fas fa-pencil-alt"></i>
    </a>
    <button type="button" class="btn action-btn" data-tooltip="Excluir">
        <i class="fas fa-trash-alt"></i>
    </button>
</div>
```

## Estilo Visual

Os estilos visuais estão definidos em:
- `public/css/admin/components/data-lists.css`: Estilos principais para listagens
- `public/css/admin/components/tooltips.css`: Estilos para tooltips

## Checklist de Validação

Antes de finalizar uma implementação, verifique se:

- [X] O cabeçalho contém título e botão de adicionar (quando aplicável)
- [X] Os filtros estão organizados em um container com a classe `filter-container`
- [X] A tabela está dentro de um container com a classe `table-container`
- [X] As células de ações estão centralizadas com a classe `text-center`
- [X] Os botões de ação estão dentro de um container com a classe `action-buttons`
- [X] Todos os botões de ação têm tooltips usando `data-tooltip`
- [X] Os badges de status usam a classe `status-badge` com `ativo` ou `inativo`
- [X] A paginação mostra informações sobre a quantidade de itens exibidos
- [X] Não há estilos CSS inline no arquivo HTML 
