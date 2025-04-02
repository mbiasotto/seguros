<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminEstablishmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Establishment::with('vendor');

        // Filtro por status (ativo/inativo)
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inactive') {
                $query->where('ativo', false);
            }
        }

        // Filtro por vendedor
        if ($request->has('vendor_id') && !empty($request->vendor_id)) {
            $query->where('vendor_id', $request->vendor_id);
        }

        // Busca por nome, email ou cidade
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $orderBy = $request->order_by ?? 'id';
        $orderDir = $request->order_dir ?? 'asc';
        $query->orderBy($orderBy, $orderDir);

        $establishments = $query->paginate(10);
        $vendors = Vendor::where('ativo', true)->orderBy('nome')->get();

        return view('admin.establishments.index', compact('establishments', 'vendors'));
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
            'numero' => 'nullable|string|max:20',
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
            'numero' => 'nullable|string|max:20',
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
