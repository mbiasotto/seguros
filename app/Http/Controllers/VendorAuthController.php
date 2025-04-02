<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class VendorAuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Mostrar o formulário de login para vendedores
     */
    public function showLoginForm()
    {
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor.auth.login');
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

        if (Auth::guard('vendor')->attempt($credentials)) {
            $request->session()->regenerate();

            // Registrar log de acesso
            $vendor = Auth::guard('vendor')->user();
            VendorAccessLog::create([
                'vendor_id' => $vendor->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('vendor.dashboard');
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
     * Permite a alteração da senha e do telefone
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.login');
        }

        $vendor = Vendor::find(Auth::guard('vendor')->id());
        $updated = false;

        // Validar os dados do formulário
        $validatedData = $request->validate([
            'telefone' => 'required|string|max:20',
            'password' => 'nullable|min:6|confirmed'
        ]);

        // Atualizar telefone
        if ($request->filled('telefone') && $vendor->telefone !== $request->telefone) {
            $vendor->telefone = $request->telefone;
            $updated = true;
        }

        // Atualizar senha se fornecida
        if ($request->filled('password')) {
            $vendor->password = Hash::make($request->password);
            $updated = true;
        }

        // Salvar alterações se houver
        if ($updated) {
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
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login');
    }
}
