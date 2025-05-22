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

        // Filtragem por tipo de documento
        if ($request->has('tipo_documento') && !empty($request->tipo_documento)) {
            $query->where('tipo_documento', $request->tipo_documento);
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
            'tipo_documento' => 'required|in:pj,pf',
            'cnpj' => 'nullable|required_if:tipo_documento,pj|string|max:18',
            'cpf' => 'nullable|required_if:tipo_documento,pf|string|max:14',
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

        // Limpar caracteres não numéricos do CPF/CNPJ
        if (isset($validated['cnpj'])) {
            $validated['cnpj'] = preg_replace('/[^0-9]/', '', $validated['cnpj']);
        }

        if (isset($validated['cpf'])) {
            $validated['cpf'] = preg_replace('/[^0-9]/', '', $validated['cpf']);
        }

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
            'tipo_documento' => 'required|in:pj,pf',
            'cnpj' => 'nullable|required_if:tipo_documento,pj|string|max:18',
            'cpf' => 'nullable|required_if:tipo_documento,pf|string|max:14',
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

        // Remove qr_codes e qr_notes do array
        unset($validated['qr_codes'], $validated['qr_notes']);

        // Limpar caracteres não numéricos do CPF/CNPJ
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

        $establishment->update($validated);

        // Atualizar QR codes
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
            ->with('success', 'Estabelecimento excluído com sucesso!');
    }

    public function show(Establishment $establishment)
    {
        $this->authorize('view', $establishment);
        $establishment->load(['category', 'qrCodes']);

        return view('vendor.establishments.show', compact('establishment'));
    }

    /**
     * Reenvia o e-mail de boas-vindas com o link do termo para o estabelecimento
     */
    public function resendTermEmail(Establishment $establishment)
    {
        $this->authorize('update', $establishment);

        try {
            // Verifica se já existe um onboarding para este estabelecimento
            $onboarding = $establishment->onboarding;

            // Se não existir ou o contrato já foi aceito, precisamos validar
            if (!$onboarding) {
                // Cria um novo onboarding, já que não existe
                $onboarding = EstablishmentOnboarding::create([
                    'establishment_id' => $establishment->id,
                    'token' => \Illuminate\Support\Str::random(64),
                ]);
            } elseif ($onboarding->contract_accepted) {
                // Se o contrato já foi aceito, informa que não é necessário reenviar
                return redirect()->route('vendor.establishments.index')
                    ->with('info', 'Este estabelecimento já aceitou os termos do contrato. Não é necessário reenviar o e-mail.');
            }

            // Envia e-mail com o link para o formulário de onboarding
            $this->emailService->sendTemplate(
                $establishment->email,
                $establishment->nome,
                'Bem-vindo ao SeguraEssa.app - Complete seu cadastro',
                'emails.establishment-welcome',
                ['establishment' => $establishment, 'onboarding' => $onboarding]
            );

            return redirect()->route('vendor.establishments.index')
                ->with('success', 'E-mail de boas-vindas reenviado com sucesso para ' . $establishment->nome);
        } catch (\Exception $e) {
            Log::error('Erro ao reenviar e-mail de boas-vindas: ' . $e->getMessage(), [
                'establishment_id' => $establishment->id
            ]);

            return redirect()->route('vendor.establishments.index')
                ->with('error', 'Erro ao reenviar o e-mail. Por favor, tente novamente.');
        }
    }

    /**
     * Cria o registro de onboarding e envia o e-mail de boas-vindas para o estabelecimento
     */
    private function createOnboardingAndSendEmail(Establishment $establishment): void
    {
        try {
            // Cria token de onboarding (sem data de expiração)
            $onboarding = EstablishmentOnboarding::create([
                'establishment_id' => $establishment->id,
                'token' => \Illuminate\Support\Str::random(64),
                // Não definimos mais a data de expiração
            ]);

            // Envia e-mail de boas-vindas com o link para o formulário de onboarding
            $this->emailService->sendTemplate(
                $establishment->email,
                $establishment->nome,
                'Bem-vindo ao SeguraEssa.app - Complete seu cadastro',
                'emails.establishment-welcome',
                ['establishment' => $establishment, 'onboarding' => $onboarding]
            );
        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail de boas-vindas: ' . $e->getMessage(), [
                'establishment_id' => $establishment->id
            ]);
        }
    }
}
