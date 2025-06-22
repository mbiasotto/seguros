<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstabelecimentoAtivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('estabelecimento')->check() && auth('estabelecimento')->user()->status !== 'ativo') {
            $status = auth('estabelecimento')->user()->status;
            auth('estabelecimento')->logout();

            return redirect()->route('estabelecimento.login')
                ->with('error', 'Sua conta está ' . $status);
        }

        return $next($request);
    }
}
