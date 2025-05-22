<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Establishment;
use App\Models\Vendor;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EstablishmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Establishment::with(['vendor', 'category']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('ativo', $status);
        }

        if ($request->filled('tipo_documento')) {
            $query->where('tipo_documento', $request->tipo_documento);
        }

        // Ordenação
        $orderBy = $request->order_by ?? 'id';
        $orderDirection = 'asc';

        if ($orderBy === 'created_at') {
            $orderDirection = 'desc';
        }

        $query->orderBy($orderBy, $orderDirection);

        $establishments = $query->paginate(config('project.per_page'));
        $vendors = Vendor::orderBy('nome')->get();
        $categories = \App\Models\Category::orderBy('nome')->get();

        return view('admin.establishments.index', compact('establishments', 'vendors', 'categories'));
    }

    public function create()
    {
        $vendors = Vendor::where('ativo', true)->get();
        $categories = Category::orderBy('nome')->get();
        $qrCodes = QrCode::orderBy('id')->get(); // Buscar todos os QR Codes
        return view('admin.establishments.create', compact('vendors', 'categories', 'qrCodes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'category_id' => 'required|exists:categories,id',
            'nome' => 'required|string|max:255',
            'tipo_documento' => 'required|in:pj,pf',
            'cnpj' => 'nullable|required_if:tipo_documento,pj|string|max:18',
            'cpf' => 'nullable|required_if:tipo_documento,pf|string|max:14',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|max:9',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:establishments,email',
            'ativo' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'qr_codes' => 'array',
            'qr_codes.*' => 'exists:qr_codes,id',
            'qr_notes' => 'array',
            'qr_notes.*' => 'nullable|string|max:500',
        ]);

        if (isset($validated['cnpj'])) {
            $validated['cnpj'] = preg_replace('/[^0-9]/', '', $validated['cnpj']);
        }

        if (isset($validated['cpf'])) {
            $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
        }

        $validated['ativo'] = $request->has('ativo');

        $fileData = [];
        if ($request->hasFile('logo')) {
            $fileData['logo'] = $request->file('logo');
            unset($validated['logo']);
        }
        if ($request->hasFile('image')) {
            $fileData['image'] = $request->file('image');
            unset($validated['image']);
        }

        $establishment = Establishment::create($validated);

        if (isset($fileData['logo'])) {
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $fileData['logo']->getClientOriginalExtension();
            $path = $fileData['logo']->storeAs(
                'establishments/logos',
                $filename,
                'public'
            );
            $establishment->logo = $path;
        }

        if (isset($fileData['image'])) {
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $fileData['image']->getClientOriginalExtension();
            $path = $fileData['image']->storeAs(
                'establishments/images',
                $filename,
                'public'
            );
            $establishment->image = $path;
        }

        if (!empty($fileData)) {
            $establishment->save();
        }

        if ($request->has('qr_codes')) {
            $qrCodes = $request->qr_codes;
            $qrNotes = $request->qr_notes ?? [];

            $syncData = [];
            foreach ($qrCodes as $qrCodeId) {
                $syncData[$qrCodeId] = [
                    'notes' => $qrNotes[$qrCodeId] ?? null
                ];
            }

            $establishment->qrCodes()->sync($syncData);
        }

        // Criar onboarding e enviar e-mail de boas-vindas independente do tipo de documento
        try {
            // Cria token de onboarding sem prazo de expiração
            $onboarding = \App\Models\EstablishmentOnboarding::create([
                'establishment_id' => $establishment->id,
                'token' => \Illuminate\Support\Str::random(64),
                'expires_at' => now()->addYear(), // Adicionando data de expiração de 1 ano
            ]);

            // Envia e-mail de boas-vindas com o link para o formulário de onboarding
            Mail::to($establishment->email)
                ->send(new \App\Mail\EstablishmentWelcome($establishment, $onboarding));
        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail de boas-vindas: ' . $e->getMessage(), [
                'establishment_id' => $establishment->id,
                'tipo_documento' => $establishment->tipo_documento
            ]);
        }

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Estabelecimento criado com sucesso!');
    }

    public function edit(Establishment $establishment)
    {
        $vendors = Vendor::where('ativo', true)->get();
        $categories = Category::orderBy('nome')->get();
        $qrCodes = QrCode::orderBy('id')->get(); // Buscar todos os QR Codes
        return view('admin.establishments.edit', compact('establishment', 'vendors', 'categories', 'qrCodes'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'category_id' => 'required|exists:categories,id',
            'nome' => 'required|string|max:255',
            'tipo_documento' => 'required|in:pj,pf',
            'cnpj' => 'nullable|required_if:tipo_documento,pj|string|max:18',
            'cpf' => 'nullable|required_if:tipo_documento,pf|string|max:14',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|max:9',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:establishments,email,' . $establishment->id,
            'ativo' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'qr_codes' => 'array',
            'qr_codes.*' => 'exists:qr_codes,id',
            'qr_notes' => 'array',
            'qr_notes.*' => 'nullable|string|max:500',
        ]);

        if (isset($validated['cnpj'])) {
            $validated['cnpj'] = preg_replace('/[^0-9]/', '', $validated['cnpj']);
        } else {
            $validated['cnpj'] = null;
        }

        if (isset($validated['cpf'])) {
            $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
        } else {
            $validated['cpf'] = null;
        }

        $validated['ativo'] = $request->has('ativo');

        if ($request->hasFile('logo')) {
            if ($establishment->logo) {
                Storage::disk('public')->delete($establishment->logo);
            }
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $request->file('logo')->getClientOriginalExtension();
            $path = $request->file('logo')->storeAs(
                'establishments/logos',
                $filename,
                'public'
            );
            $validated['logo'] = $path;
        } else {
            unset($validated['logo']);
        }

        if ($request->hasFile('image')) {
            if ($establishment->image) {
                Storage::disk('public')->delete($establishment->image);
            }
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs(
                'establishments/images',
                $filename,
                'public'
            );
            $validated['image'] = $path;
        } else {
            unset($validated['image']);
        }

        $establishment->update($validated);

        if ($request->has('qr_codes')) {
            $qrCodes = $request->qr_codes;
            $qrNotes = $request->qr_notes ?? [];

            $syncData = [];
            foreach ($qrCodes as $qrCodeId) {
                $syncData[$qrCodeId] = [
                    'notes' => $qrNotes[$qrCodeId] ?? null
                ];
            }

            $establishment->qrCodes()->sync($syncData);
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

    /**
     * Reenvia o e-mail de boas-vindas com o link do termo para o estabelecimento
     */
    public function resendTermEmail(Establishment $establishment)
    {
        try {
            // Verifica se já existe um onboarding para este estabelecimento
            $onboarding = $establishment->onboarding;

            // Se não existir ou o contrato já foi aceito, precisamos validar
            if (!$onboarding) {
                // Cria um novo onboarding, já que não existe
                $onboarding = \App\Models\EstablishmentOnboarding::create([
                    'establishment_id' => $establishment->id,
                    'token' => \Illuminate\Support\Str::random(64),
                    'expires_at' => now()->addYear(), // Adicionando data de expiração de 1 ano
                ]);
            } elseif ($onboarding->contract_accepted) {
                // Se o contrato já foi aceito, informa que não é necessário reenviar
                return redirect()->route('admin.establishments.index')
                    ->with('info', 'Este estabelecimento já aceitou os termos do contrato. Não é necessário reenviar o e-mail.');
            }

            // Envia e-mail com o link para o formulário de onboarding
            Mail::to($establishment->email)
                ->send(new \App\Mail\EstablishmentWelcome($establishment, $onboarding));

            return redirect()->route('admin.establishments.index')
                ->with('success', 'E-mail de boas-vindas reenviado com sucesso para ' . $establishment->nome);
        } catch (\Exception $e) {
            Log::error('Erro ao reenviar e-mail de boas-vindas: ' . $e->getMessage(), [
                'establishment_id' => $establishment->id
            ]);

            return redirect()->route('admin.establishments.index')
                ->with('error', 'Erro ao reenviar o e-mail. Por favor, tente novamente.');
        }
    }
}
