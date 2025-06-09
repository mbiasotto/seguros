<?php

namespace App\Http\Controllers\Establishment;

use App\Models\Establishment;
use App\Models\EstablishmentAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class EstablishmentAuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Mostrar o formulário de login para estabelecimentos
     */
    public function showLoginForm()
    {
        // Redirect to dashboard if already authenticated as establishment
        if (Auth::guard('establishment')->check()) {
            return redirect()->route('establishment.dashboard');
        }

        // Obter o email armazenado na sessão ou no cookie
        $rememberedEmail = session('establishment_remembered_email') ?? request()->cookie('establishment_remembered_email');

        return view('establishment.auth.login', compact('rememberedEmail'));
    }

    /**
     * Processar a tentativa de login para estabelecimentos
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Verificar se o checkbox "Lembrar-me" está marcado
        $remember = $request->has('remember') && $request->input('remember') == '1';

        if (Auth::guard('establishment')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Armazenar o email na sessão e no cookie se "lembrar-me" estiver marcado
            if ($remember) {
                $request->session()->put('establishment_remembered_email', $request->email);

                // Criar o cookie com mais opções
                $cookie = cookie('establishment_remembered_email', $request->email, 43200, '/', null, false, true);
                Cookie::queue($cookie);
            } else {
                $request->session()->forget('establishment_remembered_email');
                Cookie::queue(Cookie::forget('establishment_remembered_email'));
            }

            // Registrar log de acesso
            $establishment = Auth::guard('establishment')->user();
            EstablishmentAccessLog::create([
                'establishment_id' => $establishment->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Atualizar último acesso
            $establishment->update(['last_access_at' => now()]);

            return redirect()->intended(route('establishment.dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Mostrar perfil do estabelecimento
     */
    public function profile()
    {
        if (!Auth::guard('establishment')->check()) {
            return redirect()->route('establishment.login');
        }

        $establishment = Auth::guard('establishment')->user();
        return view('establishment.profile', compact('establishment'));
    }

    /**
     * Atualizar perfil do estabelecimento
     * Permite a alteração do telefone
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::guard('establishment')->check()) {
            return redirect()->route('establishment.login');
        }

        $establishment = Establishment::find(Auth::guard('establishment')->id());

        // Validar os dados do formulário
        $validatedData = $request->validate([
            'telefone' => 'required|string|max:20',
        ]);

        // Atualizar telefone
        if ($request->filled('telefone') && $establishment->telefone !== $request->telefone) {
            $establishment->telefone = $request->telefone;
            $establishment->save();

            return redirect()->route('establishment.profile')
                ->with('success', 'Perfil atualizado com sucesso!');
        }

        return redirect()->route('establishment.profile')
            ->with('info', 'Nenhuma alteração foi realizada.');
    }

    /**
     * Processar logout do estabelecimento
     */
    public function logout(Request $request)
    {
        // Verificar se o usuário marcou "Lembrar-me"
        $rememberedEmail = Cookie::get('establishment_remembered_email');
        $rememberMe = $rememberedEmail !== null;

        // Limpar o email armazenado na sessão
        $request->session()->forget('establishment_remembered_email');

        // Só remover o cookie se o usuário não marcou "Lembrar-me"
        if (!$rememberMe) {
            // Criar um cookie com expiração no passado para removê-lo
            $cookie = cookie('establishment_remembered_email', '', -1, '/', null, false, true);
            Cookie::queue($cookie);
        }

        // Only logout from establishment guard
        Auth::guard('establishment')->logout();

        // Regenerate only the CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('establishment.login');
    }
}
