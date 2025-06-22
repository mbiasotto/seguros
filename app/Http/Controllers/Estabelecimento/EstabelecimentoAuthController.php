<?php

namespace App\Http\Controllers\Estabelecimento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class EstabelecimentoAuthController extends Controller
{
    /**
     * Mostrar formulário de login
     */
    public function showLoginForm()
    {
        return view('estabelecimento.auth.login');
    }

    /**
     * Processar login
     */
    public function login(Request $request)
    {
        $request->validate([
            'cnpj' => 'required|string',
            'password' => 'required|string',
        ]);

        // Rate limiting
        $key = 'estabelecimento-login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'message' => 'Muitas tentativas de login. Tente novamente em ' . $seconds . ' segundos.'
            ], 429);
        }

        // Limpar formatação do CNPJ
        $cnpj = preg_replace('/[^0-9]/', '', $request->cnpj);

        $credentials = [
            'cnpj' => $cnpj,
            'password' => $request->password,
        ];

        if (Auth::guard('estabelecimento')->attempt($credentials, $request->boolean('remember'))) {
            $estabelecimento = Auth::guard('estabelecimento')->user();

            // Verificar se o estabelecimento está ativo
            if ($estabelecimento->status !== 'ativo') {
                Auth::guard('estabelecimento')->logout();
                RateLimiter::hit($key);

                return redirect()->route('estabelecimento.login')
                    ->with('error', 'Sua conta está ' . $estabelecimento->status);
            }

            RateLimiter::clear($key);
            $request->session()->regenerate();

            return redirect()->intended(route('estabelecimento.dashboard'));
        }

        RateLimiter::hit($key);

        return redirect()->route('estabelecimento.login')
            ->withErrors(['cnpj' => 'As credenciais não conferem com nossos registros.'])
            ->withInput($request->only('cnpj'));
    }

    /**
     * Fazer logout
     */
    public function logout(Request $request)
    {
        Auth::guard('estabelecimento')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('estabelecimento.login');
    }
}
