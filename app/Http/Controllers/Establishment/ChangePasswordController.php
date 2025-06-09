<?php

namespace App\Http\Controllers\Establishment;

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
        $this->middleware('auth:establishment');
    }

    /**
     * Mostrar formulário de alteração de senha
     */
    public function show()
    {
        $establishment = Auth::guard('establishment')->user();
        return view('establishment.change-password', compact('establishment'));
    }

    /**
     * Processar alteração de senha
     */
    public function update(Request $request)
    {
        $establishment = Auth::guard('establishment')->user();

        $validatedData = $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'A nova senha é obrigatória.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não corresponde.',
        ]);

        // Atualizar a senha
        $establishment->password = Hash::make($validatedData['password']);
        $establishment->save();

        return redirect()->route('establishment.change-password')
            ->with('success', 'Senha alterada com sucesso!');
    }
}
