<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class UsuarioAuthController extends Controller
{
    /**
     * Mostrar formulário de login
     */
    public function showLoginForm()
    {
        return view('usuario.auth.login');
    }

    /**
     * Processar login
     */
    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string',
            'password' => 'required|string',
        ]);

        // Rate limiting
        $key = 'usuario-login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'message' => 'Muitas tentativas de login. Tente novamente em ' . $seconds . ' segundos.'
            ], 429);
        }

        // Limpar formatação do CPF
        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);

        $credentials = [
            'cpf' => $cpf,
            'password' => $request->password,
        ];

        if (Auth::guard('usuario')->attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::guard('usuario')->user();

            // Verificar se o usuário está ativo
            if ($user->status !== 'ativo') {
                Auth::guard('usuario')->logout();
                RateLimiter::hit($key);

                return redirect()->route('usuario.login')
                    ->with('error', 'Sua conta está ' . $user->status);
            }

            RateLimiter::clear($key);
            $request->session()->regenerate();

            return redirect()->intended(route('usuario.dashboard'));
        }

        RateLimiter::hit($key);

        return redirect()->route('usuario.login')
            ->withErrors(['cpf' => 'As credenciais não conferem com nossos registros.'])
            ->withInput($request->only('cpf'));
    }

    /**
     * Fazer logout
     */
    public function logout(Request $request)
    {
        Auth::guard('usuario')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('usuario.login');
    }
}
