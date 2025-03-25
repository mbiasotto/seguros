<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
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
            return redirect()->route('vendor.profile');
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
            return redirect()->route('vendor.profile');
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
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.login');
        }
        
        $vendor = Vendor::find(Auth::guard('vendor')->id());

        $validated = $request->validate([
            'telefone' => 'required',
            'endereco' => 'nullable|max:255',
            'cidade' => 'nullable|max:255',
            'estado' => 'nullable|max:2',
            'cep' => 'nullable|max:9',
        ]);

        $vendor->update($validated);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:6|confirmed'
            ]);
            $vendor->password = Hash::make($request->password);
            $vendor->save();
        }

        return redirect()->route('vendor.profile')
            ->with('success', 'Perfil atualizado com sucesso!');
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
