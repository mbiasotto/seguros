<?php

namespace App\Http\Controllers;

use App\Mail\EstablishmentWelcome;
use App\Models\Establishment;
use App\Models\EstablishmentOnboarding;
use App\Services\Email\EmailServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    public function index()
    {
        $establishments = Auth::guard('vendor')->user()->establishments()->orderBy('nome')->paginate(10);
        return view('vendor.establishments.index', compact('establishments'));
    }

    public function create()
    {
        // Busca todos os QR codes ativos que não estão vinculados a nenhum estabelecimento
        // ou que estão vinculados a estabelecimentos deste vendor
        $vendorId = Auth::guard('vendor')->id();

        $qrCodes = \App\Models\QrCode::where('active', true)
            ->where(function($query) use ($vendorId) {
                $query->whereDoesntHave('establishments')
                    ->orWhereHas('establishments', function($q) use ($vendorId) {
                        $q->where('vendor_id', $vendorId);
                    });
            })
            ->get();

        return view('vendor.establishments.create', compact('qrCodes'));
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
            'email' => 'required|email|max:255',
            'descricao' => 'nullable',
            'ativo' => 'boolean',
            'qr_codes' => 'nullable|array',
            'qr_codes.*' => 'exists:qr_codes,id'
        ]);

        $qrCodes = $request->input('qr_codes', []);

        // Remove qr_codes do array de dados validados antes de criar o estabelecimento
        unset($validated['qr_codes']);

        $validated['vendor_id'] = Auth::guard('vendor')->id();
        $establishment = Establishment::create($validated);

        // Vincula os QR codes selecionados ao estabelecimento
        if (!empty($qrCodes)) {
            $establishment->qrCodes()->attach($qrCodes);
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

        $qrCodes = \App\Models\QrCode::where('active', true)
            ->where(function($query) use ($establishment, $vendorId) {
                $query->whereDoesntHave('establishments')
                    ->orWhereHas('establishments', function($q) use ($establishment, $vendorId) {
                        $q->where('establishments.id', $establishment->id)
                          ->orWhere('vendor_id', $vendorId);
                    });
            })
            ->paginate(20); // Paginação com 20 itens por página

        return view('vendor.establishments.edit', compact('establishment', 'qrCodes'));
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
            'email' => 'required|email|max:255',
            'descricao' => 'nullable',
            'ativo' => 'boolean',
            'qr_codes' => 'nullable|array',
            'qr_codes.*' => 'exists:qr_codes,id'
        ]);

        $qrCodes = $request->input('qr_codes', []);

        // Remove qr_codes do array de dados validados antes de atualizar o estabelecimento
        unset($validated['qr_codes']);

        $establishment->update($validated);

        // Sincroniza os QR codes selecionados com o estabelecimento
        $establishment->qrCodes()->sync($qrCodes);

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
            \Log::error('Erro ao enviar e-mail de boas-vindas: ' . $e->getMessage());
        }
    }
}
