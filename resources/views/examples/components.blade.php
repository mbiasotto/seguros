@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Componentes com Nova Tipografia</h1>
    <p class="text-secondary mb-4">Esta página mostra os componentes do sistema usando o novo sistema de tipografia.</p>

    <!-- Cards -->
    <section class="mb-5">
        <h2 class="mb-3">Cards</h2>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Cabeçalho do Card
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Título do Card</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Subtítulo do card</h6>
                        <p class="card-text">Este é um exemplo de card com a nova tipografia, mostrando como os diferentes elementos são exibidos.</p>
                        <a href="#" class="card-link font-medium">Link do Card</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Card Informativo</h5>
                        <p class="card-text">Cards são componentes flexíveis que podem conter texto, links, botões e outros elementos.</p>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary">Ação</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Estatísticas
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 text-center">
                                <h3 class="text-primary font-semibold">245</h3>
                                <p class="text-sm text-secondary">Estabelecimentos</p>
                            </div>
                            <div class="col-6 text-center">
                                <h3 class="text-success font-semibold">98%</h3>
                                <p class="text-sm text-secondary">Aprovação</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulários -->
    <section class="mb-5">
        <h2 class="mb-3">Formulários</h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Formulário de Exemplo</h5>

                        <form>
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Digite seu nome">
                                <div class="form-text">Informe seu nome completo.</div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Digite seu email">
                            </div>

                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="mensagem" rows="3" placeholder="Digite sua mensagem"></textarea>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="termos">
                                <label class="form-check-label" for="termos">Concordo com os termos</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Validação de Formulário</h5>

                        <form class="was-validated">
                            <div class="mb-3">
                                <label for="nome_valido" class="form-label">Nome</label>
                                <input type="text" class="form-control is-valid" id="nome_valido" value="João Silva" required>
                                <div class="valid-feedback">Nome válido!</div>
                            </div>

                            <div class="mb-3">
                                <label for="email_invalido" class="form-label">Email</label>
                                <input type="email" class="form-control is-invalid" id="email_invalido" value="email-invalido" required>
                                <div class="invalid-feedback">Por favor, forneça um email válido.</div>
                            </div>

                            <div class="mb-3">
                                <label for="selecao" class="form-label">Selecione uma opção</label>
                                <select class="form-select" id="selecao" required>
                                    <option value="">Escolha...</option>
                                    <option value="1">Opção 1</option>
                                    <option value="2">Opção 2</option>
                                    <option value="3">Opção 3</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Validar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabelas -->
    <section class="mb-5">
        <h2 class="mb-3">Tabelas</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Tabela de Dados</h5>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>João Silva</td>
                                <td>joao@exemplo.com</td>
                                <td><span class="badge bg-success">Ativo</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Editar</a>
                                    <a href="#" class="btn btn-sm btn-danger">Excluir</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Maria Santos</td>
                                <td>maria@exemplo.com</td>
                                <td><span class="badge bg-warning">Pendente</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Editar</a>
                                    <a href="#" class="btn btn-sm btn-danger">Excluir</a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Pedro Souza</td>
                                <td>pedro@exemplo.com</td>
                                <td><span class="badge bg-danger">Inativo</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Editar</a>
                                    <a href="#" class="btn btn-sm btn-danger">Excluir</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container mt-3">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Próximo</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Alertas -->
    <section class="mb-5">
        <h2 class="mb-3">Alertas</h2>

        <div class="alert alert-primary" role="alert">
            <h4 class="alert-heading font-medium">Alerta Primário</h4>
            <p>Este é um exemplo de alerta primário com a nova tipografia.</p>
        </div>

        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading font-medium">Sucesso!</h4>
            <p>A operação foi concluída com sucesso. Os dados foram salvos no sistema.</p>
        </div>

        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading font-medium">Atenção!</h4>
            <p>Verifique os dados informados antes de continuar com a operação.</p>
        </div>

        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading font-medium">Erro!</h4>
            <p>Ocorreu um erro ao processar sua solicitação. Tente novamente mais tarde.</p>
        </div>
    </section>
</div>
@endsection
