<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAuthForLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        // Se o usuário já está autenticado como vendor e tentando acessar algo dentro de /vendor
        if (Auth::guard('vendor')->check() && strpos($path, 'vendor') === 0) {
            // Se estiver tentando acessar a página de login do vendor, redireciona para o dashboard do vendor
            if ($path === 'vendor/login') {
                return redirect()->route('vendor.dashboard');
            }
            // Para outras rotas dentro de /vendor, permite o acesso se já estiver logado como vendor (ou deixa o RedirectIfAuthenticated lidar com isso)
            // No entanto, o comportamento original era redirecionar sempre para o dashboard se logado.
            // Vamos manter o redirecionamento para o dashboard para consistência, exceto se for uma sub-rota específica
            if ($path === 'vendor' || $path === 'vendor/') {
                return redirect()->route('vendor.dashboard');
            }
        }

        // Se o usuário já está autenticado como admin (web) e tentando acessar algo dentro de /admin
        if (Auth::guard('web')->check() && strpos($path, 'admin') === 0) {
            // Se estiver tentando acessar a página de login do admin, redireciona para o dashboard do admin
            if ($path === 'admin/login') {
                return redirect()->route('admin.dashboard');
            }
            // Para outras rotas dentro de /admin, permite o acesso se já estiver logado como admin
            // Vamos manter o redirecionamento para o dashboard para consistência, exceto se for uma sub-rota específica
            if ($path === 'admin' || $path === 'admin/') {
                return redirect()->route('admin.dashboard');
            }
        }

        // Se o usuário NÃO está autenticado e está tentando acessar as páginas de login, deixa passar.
        // As rotas de login (ex: admin/login, vendor/login) são geralmente protegidas pelo middleware 'guest'.
        // Se o usuário está tentando acessar a raiz (admin ou vendor) e não está logado,
        // as rotas definidas em web.php devem lidar com o redirecionamento para a página de login.

        return $next($request);
    }
}
