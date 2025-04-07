<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserAccessLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Mostrar o formulário de login
     */
    public function showLoginForm()
    {
        // Redirect to dashboard if already authenticated
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Processar a tentativa de login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Registrar log de acesso
            $user = Auth::user();
            UserAccessLog::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Redirecionar para a rota pretendida ou dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Processar logout do usuário
     */
    public function logout(Request $request)
    {
        // Only logout from web guard, do not affect vendor guard
        Auth::guard('web')->logout();

        // Do NOT invalidate the session as it would log out the vendor too
        // Only regenerate the CSRF token
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
