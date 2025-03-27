<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Verificar se a rota é para vendor
            if ($request->is('vendor/*') || $request->is('vendor')) {
                // Verificar se a rota 'vendor.login' existe
                if (Route::has('vendor.login')) {
                    return route('vendor.login');
                }
                // Fallback para URL absoluta
                return '/vendor/login';
            }

            // Verificar se a rota é para admin
            if ($request->is('admin/*') || $request->is('admin')) {
                // Verificar se a rota 'admin.login' existe
                if (Route::has('admin.login')) {
                    return route('admin.login');
                }
                // Fallback para URL absoluta
                return '/admin/login';
            }

            // Rota padrão para redirecionamento
            if (Route::has('admin.login')) {
                return route('admin.login');
            }
            
            // Fallback para URL absoluta
            return '/admin/login';
        }

        return null;
    }
}
