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
                // Redirecionamento baseado no guard específico
                if ($guard === 'usuario') {
                    return redirect('/usuario/dashboard');
                }

                if ($guard === 'estabelecimento') {
                    return redirect('/estabelecimento/dashboard');
                }

                // Default para admin/web
                return redirect('/admin/dashboard');
            }
        }

        return $next($request);
    }
}
