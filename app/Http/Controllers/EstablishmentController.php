<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class EstablishmentController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    public function index()
    {
        $establishments = Auth::guard('vendor')->user()->establishments()->orderBy('nome')->paginate(10);
        return view('vendor.establishments.index', compact('establishments'));
    }

    public function create()
    {
        return view('vendor.establishments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'cidade' => 'required|max:255',
            'estado' => 'required|size:2',
            'cep' => 'required|max:9',
            'telefone' => 'required',
            'descricao' => 'nullable',
            'ativo' => 'boolean'
        ]);

        $validated['vendor_id'] = Auth::guard('vendor')->id();
        Establishment::create($validated);

        return redirect()->route('vendor.establishments.index')
            ->with('success', 'Estabelecimento cadastrado com sucesso!');
    }

    public function edit(Establishment $establishment)
    {
        $this->authorize('update', $establishment);
        return view('vendor.establishments.edit', compact('establishment'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $this->authorize('update', $establishment);

        $validated = $request->validate([
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'cidade' => 'required|max:255',
            'estado' => 'required|size:2',
            'cep' => 'required|max:9',
            'telefone' => 'required',
            'descricao' => 'nullable',
            'ativo' => 'boolean'
        ]);

        $establishment->update($validated);
        return redirect()->route('vendor.establishments.index')
            ->with('success', 'Estabelecimento atualizado com sucesso!');
    }

    public function destroy(Establishment $establishment)
    {
        $this->authorize('delete', $establishment);
        $establishment->delete();
        return redirect()->route('vendor.establishments.index')
            ->with('success', 'Estabelecimento removido com sucesso!');
    }
}
