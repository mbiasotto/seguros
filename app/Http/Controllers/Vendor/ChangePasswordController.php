<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class ChangePasswordController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    /**
     * Mostrar formulário de alteração de senha
     */
    public function show()
    {
        $vendor = Auth::guard('vendor')->user();
        return view('vendor.change-password', compact('vendor'));
    }

    /**
     * Processar alteração de senha
     */
    public function update(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();

        $validatedData = $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'A nova senha é obrigatória.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não corresponde.',
        ]);

        // Atualizar a senha
        $vendor->password = Hash::make($validatedData['password']);
        $vendor->save();

        return redirect()->route('vendor.change-password')
            ->with('success', 'Senha alterada com sucesso!');
    }
}
