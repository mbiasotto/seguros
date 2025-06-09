<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Vendor;
use App\Models\VendorAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class VendorAuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Mostrar o formulário de login para vendedores
     */
    public function showLoginForm()
    {
        // Redirect to dashboard if already authenticated as vendor
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }

        // DO NOT redirect admin users - let them view the vendor login form

        // Obter o email armazenado na sessão ou no cookie
        $rememberedEmail = session('vendor_remembered_email') ?? request()->cookie('vendor_remembered_email');

        return view('vendor.auth.login', compact('rememberedEmail'));
    }

    /**
     * Processar a tentativa de login para vendedores
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Verificar se o checkbox "Lembrar-me" está marcado
        $remember = $request->has('remember') && $request->input('remember') == '1';

        if (Auth::guard('vendor')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Armazenar o email na sessão e no cookie se "lembrar-me" estiver marcado
            if ($remember) {
                $request->session()->put('vendor_remembered_email', $request->email);

                // Criar o cookie com mais opções
                $cookie = cookie('vendor_remembered_email', $request->email, 43200, '/', null, false, true);
                Cookie::queue($cookie);
            } else {
                $request->session()->forget('vendor_remembered_email');
                Cookie::queue(Cookie::forget('vendor_remembered_email'));
            }

            // Registrar log de acesso
            $vendor = Auth::guard('vendor')->user();
            VendorAccessLog::create([
                'vendor_id' => $vendor->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->intended(route('vendor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Mostrar perfil do vendedor
     */
    public function profile()
    {
        if (!Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.login');
        }

        $vendor = Auth::guard('vendor')->user();
        return view('vendor.profile', compact('vendor'));
    }

    /**
     * Atualizar perfil do vendedor
     * Permite a alteração do telefone
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.login');
        }

        $vendor = Vendor::find(Auth::guard('vendor')->id());

        // Validar os dados do formulário
        $validatedData = $request->validate([
            'telefone' => 'required|string|max:20',
        ]);

        // Atualizar telefone
        if ($request->filled('telefone') && $vendor->telefone !== $request->telefone) {
            $vendor->telefone = $request->telefone;
            $vendor->save();

            return redirect()->route('vendor.profile')
                ->with('success', 'Perfil atualizado com sucesso!');
        }

        return redirect()->route('vendor.profile')
            ->with('info', 'Nenhuma alteração foi realizada.');
    }

    /**
     * Processar logout do vendedor
     */
    public function logout(Request $request)
    {
        // Verificar se o usuário marcou "Lembrar-me"
        $rememberedEmail = Cookie::get('vendor_remembered_email');
        $rememberMe = $rememberedEmail !== null;

        // Limpar o email armazenado na sessão
        $request->session()->forget('vendor_remembered_email');

        // Só remover o cookie se o usuário não marcou "Lembrar-me"
        if (!$rememberMe) {
            // Criar um cookie com expiração no passado para removê-lo
            $cookie = cookie('vendor_remembered_email', '', -1, '/', null, false, true);
            Cookie::queue($cookie);
        }

        // Only logout from vendor guard, not default web guard
        Auth::guard('vendor')->logout();

        // We don't want to invalidate the entire session as it would affect admin auth
        // Instead, regenerate only the CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }
}
