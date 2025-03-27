<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Tratamento para rotas não encontradas
        $this->renderable(function (NotFoundHttpException $e, $request) {
            Log::info('NotFoundHttpException - Request Path: ' . $request->path());

            if ($request->is('admin/*') || $request->is('admin')) {
                return redirect('/admin/login');
            }

            if ($request->is('vendor/*') || $request->is('vendor')) {
                return redirect('/vendor/login');
            }

            return null; // Let Laravel handle other 404 errors
        });

        // Tratamento para erros de rota não encontrada
        $this->renderable(function (RouteNotFoundException $e, $request) {
            Log::info('RouteNotFoundException - Request Path: ' . $request->path());
            Log::info('RouteNotFoundException - Message: ' . $e->getMessage());

            // Se a mensagem de erro contém "Route [login]", significa que está tentando redirecionar para uma rota de login não definida
            if (strpos($e->getMessage(), 'Route [login]') !== false) {
                // Verificar o caminho da requisição para determinar para onde redirecionar
                if (strpos($request->path(), 'vendor') === 0) {
                    return redirect('/vendor/login');
                }
                
                return redirect('/admin/login');
            }
            
            if ($request->is('admin/*') || $request->is('admin')) {
                return redirect('/admin/login');
            }

            if ($request->is('vendor/*') || $request->is('vendor')) {
                return redirect('/vendor/login');
            }

            return null; // Let Laravel handle other route errors
        });
        
        // Tratamento para erros de autenticação
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            if ($request->is('admin/*') || $request->is('admin')) {
                return redirect('/admin/login');
            }

            if ($request->is('vendor/*') || $request->is('vendor')) {
                return redirect('/vendor/login');
            }

            return redirect('/admin/login');
        });
    }

    public function render($request, Throwable $e)
    {
        Log::info('Request Path: ' . $request->path());
        
        // Apenas registre o erro se não for relacionado à autenticação ou rota
        if (!($e instanceof AuthenticationException) && !($e instanceof NotFoundHttpException) && !($e instanceof RouteNotFoundException)) {
            Log::error('Exception Message: ' . $e->getMessage());
        }

        // Tratamento para erros de rota
        if ($e instanceof RouteNotFoundException) {
            Log::info('RouteNotFoundException: ' . $e->getMessage());
            
            // Se a mensagem de erro contém "Route [login]", significa que está tentando redirecionar para uma rota de login não definida
            if (strpos($e->getMessage(), 'Route [login]') !== false) {
                // Verificar o caminho da requisição para determinar para onde redirecionar
                if (strpos($request->path(), 'vendor') === 0) {
                    return redirect('/vendor/login');
                }
                
                return redirect('/admin/login');
            }
            
            if (strpos($request->path(), 'admin') === 0) {
                return redirect('/admin/login');
            }

            if (strpos($request->path(), 'vendor') === 0) {
                return redirect('/vendor/login');
            }
        }

        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guard = data_get($exception->guards(), 0);

        // Primeiro verificamos o caminho da requisição para determinar para onde redirecionar
        if ($request->is('vendor/*') || $request->is('vendor')) {
            try {
                return redirect()->route('vendor.login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
            } catch (RouteNotFoundException $e) {
                return redirect('/vendor/login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
            }
        }

        if ($request->is('admin/*') || $request->is('admin')) {
            try {
                return redirect()->route('admin.login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
            } catch (RouteNotFoundException $e) {
                return redirect('/admin/login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
            }
        }

        // Se não conseguirmos determinar pelo caminho, usamos o guard
        switch ($guard) {
            case 'vendor':
                try {
                    return redirect()->route('vendor.login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
                } catch (RouteNotFoundException $e) {
                    return redirect('/vendor/login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
                }
            case 'web':
            default:
                try {
                    return redirect()->route('admin.login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
                } catch (RouteNotFoundException $e) {
                    return redirect('/admin/login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
                }
        }
    }
}
