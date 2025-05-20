<?php

namespace App\Http\Controllers\Vendor;

use App\Mail\EstablishmentWelcome;
use App\Models\Category;
use App\Models\Establishment;
use App\Models\EstablishmentOnboarding;
use App\Models\QrCode;
use App\Services\Email\EmailServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

class EstablishmentController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Serviço de e-mail
     */
    private EmailServiceInterface $emailService;

    public function __construct(EmailServiceInterface $emailService)
    {
        $this->middleware('auth:vendor');
        $this->emailService = $emailService;
    }

    public function index(Request $request)
    {
        $query = Auth::guard('vendor')->user()->establishments();

        // Filtro por status (ativo/inativo)
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inactive') {
                $query->where('ativo', false);
            }
        }

        // Busca por nome, cidade ou telefone
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtragem por estado
        if ($request->has('estado') && !empty($request->estado)) {
            $query->where('estado', $request->estado);
        }

        // Ordenação
        $orderBy = $request->order_by ?? 'nome';
        $orderDir = $request->order_dir ?? 'asc';
        $query->orderBy($orderBy, $orderDir);

        $establishments = $query->paginate(config('project.per_page'));

        // Buscar estados únicos para o filtro
        $estados = Auth::guard('vendor')->user()->establishments()
            ->select('estado')
            ->distinct()
            ->whereNotNull('estado')
            ->pluck('estado');

        // Buscar categorias
        $categories = Category::orderBy('nome')->get();

        return view('vendor.establishments.index', compact('establishments', 'estados', 'categories'));
    }

    public function create()
    {
        // Busca todos os QR codes ativos que não estão vinculados a nenhum estabelecimento
        // ou que estão vinculados a estabelecimentos deste vendor
        $vendorId = Auth::guard('vendor')->id();

        $qrCodes = QrCode::where('active', true)
            ->where(function($query) use ($vendorId) {
                $query->whereDoesntHave('establishments')
                    ->orWhereHas('establishments', function($q) use ($vendorId) {
                        $q->where('vendor_id', $vendorId);
                    });
            })
            ->get();

        // Buscar categorias
        $categories = Category::orderBy('nome')->get();

        return view('vendor.establishments.create', compact('qrCodes', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'numero' => 'nullable|string|max:20',
            'cidade' => 'required|max:255',
            'estado' => 'required|size:2',
            'cep' => 'required|max:9',
            'telefone' => 'required',
            'email' => 'required|email|max:255',
            'descricao' => 'nullable',
            'ativo' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'qr_codes' => 'nullable|array',
            'qr_codes.*' => 'exists:qr_codes,id',
            'qr_notes' => 'nullable|array',
            'qr_notes.*' => 'nullable|string|max:500',
        ]);

        $qrCodes = $request->input('qr_codes', []);
        $qrNotes = $request->input('qr_notes', []);

        // Remove qr_codes e qr_notes do array de dados validados antes de criar o estabelecimento
        unset($validated['qr_codes'], $validated['qr_notes']);

        $validated['vendor_id'] = Auth::guard('vendor')->id();
        $establishment = Establishment::create($validated);

        // Vincula os QR codes selecionados ao estabelecimento com suas anotações
        if (!empty($qrCodes)) {
            $syncData = [];
            foreach ($qrCodes as $qrCodeId) {
                $syncData[$qrCodeId] = [
                    'notes' => $qrNotes[$qrCodeId] ?? null
                ];
            }

            $establishment->qrCodes()->sync($syncData);
        }

        // Cria o registro de onboarding para o estabelecimento
        $this->createOnboardingAndSendEmail($establishment);

        return redirect()->route('vendor.establishments.index')
            ->with('success', 'Estabelecimento cadastrado com sucesso! Um e-mail de boas-vindas foi enviado.');
    }

    public function edit(Establishment $establishment)
    {
        // Verifica se o usuário atual tem permissão para editar este estabelecimento
        $this->authorize('update', $establishment);

        // Busca todos os QR codes ativos ou que já estejam vinculados a este estabelecimento
        // Implementando paginação para lidar com grande quantidade de QR codes
        $vendorId = Auth::guard('vendor')->id();

        $qrCodes = QrCode::where('active', true)
            ->where(function($query) use ($establishment, $vendorId) {
                $query->whereDoesntHave('establishments')
                    ->orWhereHas('establishments', function($q) use ($establishment, $vendorId) {
                        $q->where('establishments.id', $establishment->id)
                          ->orWhere('vendor_id', $vendorId);
                    });
            })
            ->paginate(config('project.per_page')); // Paginação com 20 itens por página

        // Buscar categorias
        $categories = Category::orderBy('nome')->get();

        return view('vendor.establishments.edit', compact('establishment', 'qrCodes', 'categories'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $this->authorize('update', $establishment);

        $validated = $request->validate([
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'numero' => 'nullable|string|max:20',
            'cidade' => 'required|max:255',
            'estado' => 'required|size:2',
            'cep' => 'required|max:9',
            'telefone' => 'required',
            'email' => 'required|email|max:255',
            'descricao' => 'nullable',
            'ativo' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'qr_codes' => 'nullable|array',
            'qr_codes.*' => 'exists:qr_codes,id',
            'qr_notes' => 'nullable|array',
            'qr_notes.*' => 'nullable|string|max:500',
        ]);

        $qrCodes = $request->input('qr_codes', []);
        $qrNotes = $request->input('qr_notes', []);

        // Remove qr_codes e qr_notes do array de dados validados antes de atualizar o estabelecimento
        unset($validated['qr_codes'], $validated['qr_notes']);

        $establishment->update($validated);

        // Sincroniza os QR codes selecionados com o estabelecimento e suas anotações
        if (!empty($qrCodes)) {
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

    public function show(Establishment $establishment)
    {
        $this->authorize('view', $establishment);
        return view('vendor.establishments.show', compact('establishment'));
    }

    /**
     * Cria o registro de onboarding e envia o e-mail de boas-vindas para o estabelecimento
     */
    private function createOnboardingAndSendEmail(Establishment $establishment): void
    {
        try {
            // Cria o registro de onboarding
            $onboarding = EstablishmentOnboarding::create([
                'establishment_id' => $establishment->id,
                'token' => EstablishmentOnboarding::generateUniqueToken(),
                'expires_at' => now()->addDays(7) // Token válido por 7 dias
            ]);

            // Envia o e-mail de boas-vindas
            if ($establishment->email) {
                // Usando o serviço de e-mail
                $this->emailService->sendTemplate(
                    $establishment->email,
                    $establishment->nome,
                    'Bem-vindo ao SeguraEssa.app - Complete seu cadastro',
                    'emails.establishment-welcome',
                    ['establishment' => $establishment, 'onboarding' => $onboarding]
                );
            }
        } catch (\Exception $e) {
            // Registra o erro, mas não interrompe o fluxo
            // Não vamos registrar o log aqui para evitar erros
        }
    }
}
