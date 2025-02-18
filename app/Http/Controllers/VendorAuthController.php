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
    public function __construct()
    {
        $this->middleware('guest:vendor')->except(['profile', 'updateProfile', 'logout']);
        $this->middleware('auth:vendor')->only(['profile', 'updateProfile', 'logout']);
    }

    protected function redirectTo()
    {
        return route('vendor.dashboard');
    }

    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

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

    public function profile()
    {
        $vendor = Auth::guard('vendor')->user();
        return view('vendor.profile', compact('vendor'));
    }

    public function updateProfile(Request $request)
    {
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

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login');
    }
}
