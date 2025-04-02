<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$guards
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Verificar qual guarda está sendo usado para determinar o redirecionamento

                // Se for o guarda vendor, apenas redirecionar para vendor dashboard
                if ($guard === 'vendor') {
                    // Verificar se estamos em uma rota vendor
                    if (strpos($request->path(), 'vendor') === 0) {
                        return redirect()->route('vendor.dashboard');
                    }
                }

                // Se for o guarda web/admin, apenas redirecionar para admin dashboard
                if ($guard === 'web' || $guard === null) {
                    // Verificar se estamos em uma rota admin
                    if (strpos($request->path(), 'admin') === 0) {
                        return redirect()->route('admin.dashboard');
                    }
                }
            }
        }

        return $next($request);
    }
}
