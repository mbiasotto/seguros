<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\RecargaPrepago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecargaController extends Controller
{
    /**
     * Listar recargas do usuário
     */
    public function index()
    {
        $usuario = Auth::guard('usuario')->user();

        $recargas = RecargaPrepago::where('usuario_id', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('usuario.recargas.index', compact('recargas'));
    }

    /**
     * Mostrar formulário para criar recarga
     */
    public function create()
    {
        return view('usuario.recargas.create');
    }

    /**
     * Processar solicitação de recarga
     */
    public function store(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric|min:10|max:1000',
            'descricao' => 'nullable|string|max:255'
        ]);

        $usuario = Auth::guard('usuario')->user();

        RecargaPrepago::create([
            'usuario_id' => $usuario->id,
            'valor' => $request->valor,
            'descricao' => $request->descricao,
            'status' => RecargaPrepago::STATUS_PENDENTE
        ]);

        return redirect()->route('usuario.recargas.index')
            ->with('success', 'Solicitação de recarga enviada com sucesso! Aguarde a aprovação.');
    }
}
