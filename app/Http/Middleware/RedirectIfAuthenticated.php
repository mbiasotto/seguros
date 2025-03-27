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
                // Se o usuário já está autenticado e tenta acessar uma rota de login
                if ($guard === 'vendor') {
                    // Se for um vendedor autenticado
                    return redirect()->route('vendor.dashboard');
                }

                // Se for um admin autenticado
                return redirect()->route('admin.dashboard');
            }
        }

        // Se o usuário não está autenticado, continua o fluxo normal
        return $next($request);
    }
}
