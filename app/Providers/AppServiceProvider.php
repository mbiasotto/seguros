<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuração da paginação para usar o Bootstrap
        Paginator::useBootstrap();

        // Garantir que os links de paginação mantenham os parâmetros de consulta
        LengthAwarePaginator::defaultView('pagination::bootstrap-5');
        LengthAwarePaginator::defaultSimpleView('pagination::simple-bootstrap-5');

        // Adicionar método para preservar query strings automaticamente
        LengthAwarePaginator::viewFactoryResolver(function () {
            return view();
        });

        // Garantir que todos os paginadores preservem os parâmetros de consulta
        Paginator::useBootstrapFive();

        // Configurar para que todos os paginadores preservem automaticamente os parâmetros de consulta
        LengthAwarePaginator::useBootstrapFive();
    }
}
