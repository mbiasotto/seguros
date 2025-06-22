@extends('layouts.site')

@section('title', 'Rede Credenciada - Multiplic.cc')

@section('content')
    <!-- Header Section -->
    <section class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Rede Credenciada</h1>
                    <p class="lead">Mais de 1.000 estabelecimentos parceiros em todo o Brasil</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-warning">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="text-dark">
                        <h2 class="display-5 fw-bold">1000+</h2>
                        <h5>Estabelecimentos</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-dark">
                        <h2 class="display-5 fw-bold">50+</h2>
                        <h5>Cidades</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-dark">
                        <h2 class="display-5 fw-bold">15</h2>
                        <h5>Estados</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-dark">
                        <h2 class="display-5 fw-bold">24h</h2>
                        <h5>Disponibilidade</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            <!-- Filtros -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Encontre Estabelecimentos Próximos</h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado">
                                        <option value="">Todos os Estados</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PR">Paraná</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <select class="form-select" id="cidade">
                                        <option value="">Todas as Cidades</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="categoria" class="form-label">Categoria</label>
                                    <select class="form-select" id="categoria">
                                        <option value="">Todas as Categorias</option>
                                        <option value="supermercado">Supermercados</option>
                                        <option value="farmacia">Farmácias</option>
                                        <option value="posto">Postos de Combustível</option>
                                        <option value="restaurante">Restaurantes</option>
                                        <option value="loja">Lojas de Roupas</option>
                                        <option value="padaria">Padarias</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Estabelecimentos por Categoria -->
            <div class="row">
                <div class="col-12">
                    <!-- Supermercados -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-shopping-cart me-2"></i>Supermercados
                        </h3>
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-success rounded-circle mx-auto mb-3">
                                            <i class="fas fa-store text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Pão de Açúcar</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-primary rounded-circle mx-auto mb-3">
                                            <i class="fas fa-store text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Carrefour</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-warning rounded-circle mx-auto mb-3">
                                            <i class="fas fa-store text-dark"></i>
                                        </div>
                                        <h5 class="fw-bold">Extra</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-info rounded-circle mx-auto mb-3">
                                            <i class="fas fa-store text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Assaí</h5>
                                        <p class="text-muted small mb-0">Atacadista</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Farmácias -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-pills me-2"></i>Farmácias
                        </h3>
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-danger rounded-circle mx-auto mb-3">
                                            <i class="fas fa-plus text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Droga Raia</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-success rounded-circle mx-auto mb-3">
                                            <i class="fas fa-plus text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Drogasil</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-primary rounded-circle mx-auto mb-3">
                                            <i class="fas fa-plus text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Pacheco</h5>
                                        <p class="text-muted small mb-0">Rio de Janeiro</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-warning rounded-circle mx-auto mb-3">
                                            <i class="fas fa-plus text-dark"></i>
                                        </div>
                                        <h5 class="fw-bold">Onofre</h5>
                                        <p class="text-muted small mb-0">São Paulo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Postos de Combustível -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-gas-pump me-2"></i>Postos de Combustível
                        </h3>
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-danger rounded-circle mx-auto mb-3">
                                            <i class="fas fa-gas-pump text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Shell</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-success rounded-circle mx-auto mb-3">
                                            <i class="fas fa-gas-pump text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">BR Petrobras</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-primary rounded-circle mx-auto mb-3">
                                            <i class="fas fa-gas-pump text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Ipiranga</h5>
                                        <p class="text-muted small mb-0">Rede nacional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-warning rounded-circle mx-auto mb-3">
                                            <i class="fas fa-gas-pump text-dark"></i>
                                        </div>
                                        <h5 class="fw-bold">Ale</h5>
                                        <p class="text-muted small mb-0">São Paulo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Restaurantes -->
                    <div class="mb-5">
                        <h3 class="fw-bold mb-4 text-warning">
                            <i class="fas fa-utensils me-2"></i>Restaurantes e Alimentação
                        </h3>
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-danger rounded-circle mx-auto mb-3">
                                            <i class="fas fa-hamburger text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">McDonald's</h5>
                                        <p class="text-muted small mb-0">Fast food</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-primary rounded-circle mx-auto mb-3">
                                            <i class="fas fa-pizza-slice text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Domino's</h5>
                                        <p class="text-muted small mb-0">Pizzaria</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-success rounded-circle mx-auto mb-3">
                                            <i class="fas fa-coffee text-white"></i>
                                        </div>
                                        <h5 class="fw-bold">Starbucks</h5>
                                        <p class="text-muted small mb-0">Cafeteria</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="store-logo bg-warning rounded-circle mx-auto mb-3">
                                            <i class="fas fa-utensils text-dark"></i>
                                        </div>
                                        <h5 class="fw-bold">Outback</h5>
                                        <p class="text-muted small mb-0">Restaurante</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Como Participar -->
                    <div class="mt-5">
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body p-5 text-center">
                                <h3 class="fw-bold mb-4">Quer fazer parte da nossa rede?</h3>
                                <p class="lead mb-4">
                                    Seja um estabelecimento parceiro e aumente suas vendas com o cartão Multiplic.cc
                                </p>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="text-warning">
                                                    <i class="fas fa-handshake fs-1 mb-2"></i>
                                                    <h5>Parceria Gratuita</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="text-warning">
                                                    <i class="fas fa-chart-line fs-1 mb-2"></i>
                                                    <h5>Aumento de Vendas</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="text-warning">
                                                    <i class="fas fa-users fs-1 mb-2"></i>
                                                    <h5>Novos Clientes</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('site.contato') }}" class="btn btn-warning btn-lg fw-bold text-dark px-5">
                                    Entre em Contato
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Styles -->
    <style>
        .store-logo {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
@endsection
