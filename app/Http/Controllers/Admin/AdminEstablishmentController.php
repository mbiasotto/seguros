<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminEstablishmentController extends Controller
{
    public function index()
    {
        $establishments = Establishment::with('vendor')->paginate(10);
        return view('admin.establishments.index', compact('establishments'));
    }

    public function create()
    {
        $vendors = Vendor::where('ativo', true)->get();
        $qrCodes = \App\Models\QrCode::where('active', true)->get();
        return view('admin.establishments.create', compact('vendors', 'qrCodes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:2',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'ativo' => 'boolean',
            'qr_codes' => 'nullable|array',
            'qr_codes.*' => 'exists:qr_codes,id'
        ]);

        $qrCodes = $request->input('qr_codes', []);

        // Remove qr_codes do array de dados validados antes de criar o estabelecimento
        unset($validated['qr_codes']);

        $establishment = Establishment::create($validated);

        // Vincula os QR codes selecionados ao estabelecimento
        if (!empty($qrCodes)) {
            $establishment->qrCodes()->attach($qrCodes);
        }

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Estabelecimento criado com sucesso!');
    }

    public function edit(Establishment $establishment)
    {
        $vendors = Vendor::where('ativo', true)->get();

        // Busca todos os QR codes ativos ou que já estejam vinculados a este estabelecimento
        // Implementando paginação para lidar com grande quantidade de QR codes
        $qrCodes = \App\Models\QrCode::where('active', true)
            ->orWhereHas('establishments', function($query) use ($establishment) {
                $query->where('establishments.id', $establishment->id);
            })
            ->paginate(20); // Paginação com 20 itens por página

        return view('admin.establishments.edit', compact('establishment', 'vendors', 'qrCodes'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:2',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'ativo' => 'boolean',
            'qr_codes' => 'nullable|array',
            'qr_codes.*' => 'exists:qr_codes,id'
        ]);

        $qrCodes = $request->input('qr_codes', []);

        // Remove qr_codes do array de dados validados antes de atualizar o estabelecimento
        unset($validated['qr_codes']);

        $establishment->update($validated);

        // Sincroniza os QR codes selecionados com o estabelecimento
        // O método sync substitui todos os relacionamentos existentes
        $establishment->qrCodes()->sync($qrCodes);

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
