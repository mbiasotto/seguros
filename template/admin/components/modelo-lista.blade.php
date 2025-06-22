{{--
    Modelo de Listagem para Páginas Admin
    Segura Essa - Sistema de Gestão de Estabelecimentos

    Instruções de uso:
    1. Copie este arquivo como base para criar suas listagens
    2. Personalize os campos e ações conforme necessário
    3. Mantenha a consistência visual em todas as listagens
--}}

<div class="data-list-header">
    <h1 class="h3 mb-0">Título da Listagem</h1>
    <a href="#" class="btn btn-primary d-flex align-items-center gap-2" data-tooltip="Adicionar Novo">
        <i class="fas fa-plus"></i>
        <span>Novo</span>
    </a>
</div>

<!-- Filtros -->
<div class="filter-container shadow-sm">
    <form action="#" method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Termos de busca..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label for="filtro1" class="form-label">Filtro 1</label>
            <select class="form-select" id="filtro1" name="filtro1">
                <option value="">Todos</option>
                <option value="opcao1">Opção 1</option>
                <option value="opcao2">Opção 2</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="">Todos</option>
                <option value="active">Ativos</option>
                <option value="inactive">Inativos</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="order_by" class="form-label">Ordenar por</label>
            <select class="form-select" id="order_by" name="order_by">
                <option value="nome">Nome</option>
                <option value="data">Data</option>
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100" data-tooltip="Aplicar Filtros">Filtrar</button>
        </div>
    </form>
</div>

<!-- Estado Vazio (usar se a lista estiver vazia) -->
<div class="card border-0 shadow-sm d-none">
    <div class="card-body empty-state text-center py-5">
        <div class="empty-state-icon mb-4 rounded-circle p-4 d-inline-flex justify-content-center align-items-center">
            <i class="fas fa-list fa-3x"></i>
        </div>
        <h3 class="fw-bold mb-3">Nenhum item encontrado</h3>
        <p class="text-muted mb-4 col-md-8 mx-auto">Não existem itens cadastrados ou que correspondam aos filtros utilizados.</p>
        <div class="mt-4">
            <a href="#" class="btn btn-primary d-flex align-items-center gap-2 mx-auto" style="width: fit-content;" data-tooltip="Adicionar Novo">
                <i class="fas fa-plus"></i>
                <span>Novo</span>
            </a>
        </div>
    </div>
</div>

<!-- Tabela de Dados (remover a classe d-none e usar quando houver dados) -->
<div class="card border-0 shadow-sm">
    <div class="table-container">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Campo 1</th>
                    <th>Campo 2</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo de linha -->
                <tr>
                    <td>1</td>
                    <td>Nome do Item</td>
                    <td>Valor Campo 1</td>
                    <td>Valor Campo 2</td>
                    <td>
                        <span class="status-badge ativo">Ativo</span>
                        <!-- Ou usar: <span class="status-badge inativo">Inativo</span> -->
                    </td>
                    <td>01/01/2023</td>
                    <td>
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
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Paginação (usar apenas se houver paginação) -->
<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="pagination-info">
        Mostrando 1 a 10 de 100 resultados
    </div>
    <!-- Aqui vai a paginação: {{ $itens->links() }} -->
</div>

{{--
    Dicas de uso:

    1. Para badges de status, use a classe "status-badge" com uma das seguintes classes:
       - ativo: Verde para status ativos/aprovados
       - inativo: Vermelho para status inativos/reprovados

    2. Para botões de ação, use a estrutura:
       <div class="action-buttons">
           <a href="#" class="btn action-btn" data-tooltip="Texto do Tooltip">
               <i class="fas fa-icon"></i>
           </a>
       </div>

    3. Para manter a consistência visual, sempre use:
       - Cabeçalho da lista com data-list-header
       - Filtros em filter-container
       - Tabelas dentro de table-container
       - Estados vazios com empty-state
--}}
