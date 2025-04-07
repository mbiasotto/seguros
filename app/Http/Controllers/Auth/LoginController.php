<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserAccessLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
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

        // Obter o email armazenado na sessão ou no cookie
        $rememberedEmail = session('remembered_email') ?? Cookie::get('remembered_email');

        return view('admin.auth.login', compact('rememberedEmail'));
    }

    /**
     * Processar a tentativa de login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Verificar se o checkbox "Lembrar-me" está marcado
        $remember = $request->has('remember') && $request->input('remember') == '1';

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Armazenar o email na sessão e no cookie se "lembrar-me" estiver marcado
            if ($remember) {
                $request->session()->put('remembered_email', $request->email);

                // Criar o cookie com mais opções
                $cookie = cookie('remembered_email', $request->email, 43200, '/', null, false, true);
                Cookie::queue($cookie);
            } else {
                $request->session()->forget('remembered_email');
                Cookie::queue(Cookie::forget('remembered_email'));
            }

            // Registrar log de acesso
            $user = Auth::user();
            UserAccessLog::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

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
        // Verificar se o usuário marcou "Lembrar-me"
        $rememberedEmail = Cookie::get('remembered_email');
        $rememberMe = $rememberedEmail !== null;

        // Limpar o email armazenado na sessão
        $request->session()->forget('remembered_email');

        // Só remover o cookie se o usuário não marcou "Lembrar-me"
        if (!$rememberMe) {
            // Criar um cookie com expiração no passado para removê-lo
            $cookie = cookie('remembered_email', '', -1, '/', null, false, true);
            Cookie::queue($cookie);
        }

        // Only logout from web guard, do not affect vendor guard
        Auth::guard('web')->logout();

        // Do NOT invalidate the session as it would log out the vendor too
        // Only regenerate the CSRF token
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
