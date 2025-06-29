<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('vendor/*') || $request->is('vendor')) {
                return route('vendor.login');
            }
            return route('admin.login');
        });

        $middleware->validateCsrfTokens(except: [
            'api/*', // Exclude all API routes from CSRF protection
        ]);

        // Registrar middlewares customizados
        $middleware->alias([
            'usuario.ativo' => \App\Http\Middleware\UsuarioAtivo::class,
            'estabelecimento.ativo' => \App\Http\Middleware\EstabelecimentoAtivo::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
