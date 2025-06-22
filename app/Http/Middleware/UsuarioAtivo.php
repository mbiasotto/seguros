<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioAtivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('usuario')->check() && auth('usuario')->user()->status !== 'ativo') {
            $status = auth('usuario')->user()->status;
            auth('usuario')->logout();

            return redirect()->route('usuario.login')
                ->with('error', 'Sua conta está ' . $status);
        }

        return $next($request);
    }
}
