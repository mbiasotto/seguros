<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Vendor;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    public function index()
    {
        $establishments = Establishment::with('vendor')->paginate(10);
        return view('admin.establishments.index', compact('establishments'));
    }

    public function create()
    {
        $vendors = Vendor::where('ativo', true)->get();
        return view('admin.establishments.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'ativo' => 'boolean',
            'qr_codes' => 'array'
        ]);

        $establishment = Establishment::create($validated);

        if ($request->has('qr_codes')) {
            $establishment->qrCodes()->sync($request->qr_codes);
        }

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Estabelecimento criado com sucesso!');
    }

    public function edit(Establishment $establishment)
    {
        $vendors = Vendor::where('ativo', true)->get();
        return view('admin.establishments.edit', compact('establishment', 'vendors'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'ativo' => 'boolean',
            'qr_codes' => 'array'
        ]);

        $establishment->update($validated);

        if ($request->has('qr_codes')) {
            $establishment->qrCodes()->sync($request->qr_codes);
        } else {
            $establishment->qrCodes()->detach();
        }

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Estabelecimento atualizado com sucesso!');
    }

    public function destroy(Establishment $establishment)
    {
        $establishment->delete();

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Estabelecimento excluído com sucesso!');
    }
}
