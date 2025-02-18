<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;

class VendorController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendors = Vendor::orderBy('nome')->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6|confirmed',
            'telefone' => 'required',
            'endereco' => 'nullable|max:255',
            'cidade' => 'nullable|max:255',
            'estado' => 'nullable|max:2',
            'cep' => 'nullable|max:9',
            'observacoes' => 'nullable',
            'ativo' => 'boolean'
        ]);

        $validated['password'] = Hash::make($request->password);
        Vendor::create($validated);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendedor cadastrado com sucesso!');
    }

    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'telefone' => 'required',
            'endereco' => 'nullable|max:255',
            'cidade' => 'nullable|max:255',
            'estado' => 'nullable|max:2',
            'cep' => 'nullable|max:9',
            'observacoes' => 'nullable',
            'ativo' => 'boolean'
        ]);

        $vendor->update($validated);
        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendedor atualizado com sucesso!');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendedor removido com sucesso!');
    }
}
