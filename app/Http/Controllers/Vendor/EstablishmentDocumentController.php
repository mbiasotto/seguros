<?php

namespace App\Http\Controllers\Vendor;

// Use BaseController and necessary traits
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\EstablishmentOnboarding;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

// Use BaseController instead of just Controller
class EstablishmentDocumentController extends BaseController
{
    // Add the necessary traits
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Construtor
     */
    public function __construct()
    {
        // Middleware aplicado através da rota ou grupo de rotas
    }

    /**
     * Exibe a lista de documentos dos estabelecimentos do vendedor
     */
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();

        $documents = EstablishmentOnboarding::whereHas('establishment', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })
        ->whereNotNull('document_path') // Garante que há um path
        ->with(['establishment', 'approvedByUser'])
        ->orderByDesc('completed_at')
        ->paginate(10);

        return view('vendor.establishments.documents.index', compact('documents'));
    }

    /**
     * Exibe os detalhes de um documento
     */
    public function show(EstablishmentOnboarding $onboarding)
    {
        // Verificar se o onboarding pertence a um estabelecimento do vendedor logado
        $this->authorize('view', $onboarding->establishment);

        // Garantir que o modelo Establishment está sendo usado corretamente e tem documento
        abort_unless($onboarding->establishment->vendor_id === auth('vendor')->id() && $onboarding->document_path, 403);

        return view('vendor.establishments.documents.show', compact('onboarding'));
    }

    /**
     * Visualiza/Baixa o documento enviado pelo estabelecimento
     */
    public function viewDocument(EstablishmentOnboarding $onboarding)
    {
        // Verificar se o onboarding pertence a um estabelecimento do vendedor logado
        $this->authorize('view', $onboarding->establishment);

        // Garantir que o modelo Establishment está sendo usado corretamente
        abort_unless($onboarding->establishment->vendor_id === auth('vendor')->id(), 403);

        if (!$onboarding->document_path || !Storage::disk('private')->exists($onboarding->document_path)) {
            return redirect()->back()->with('error', 'Documento não encontrado ou não enviado.');
        }

        // Retorna o arquivo como download
        $path = Storage::disk('private')->path($onboarding->document_path);
        $mimeType = mime_content_type($path) ?: 'application/octet-stream';
        $filename = basename($onboarding->document_path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    /**
     * Exibe a lista de documentos pendentes
     */
    public function pending()
    {
        $vendor = Auth::guard('vendor')->user();

        $pendingDocuments = EstablishmentOnboarding::whereHas('establishment', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })
        ->whereNotNull('document_path')
        ->where('document_approved', false)
        ->whereNull('document_approved_at')
        ->with('establishment')
        ->orderBy('completed_at')
        ->paginate(10);

        return view('vendor.establishments.documents.pending', compact('pendingDocuments'));
    }

    /**
     * Exibe a lista de documentos aprovados
     */
    public function approved()
    {
        $vendor = Auth::guard('vendor')->user();

        $approvedDocuments = EstablishmentOnboarding::whereHas('establishment', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })
        ->whereNotNull('document_path')
        ->where('document_approved', true)
        ->whereNotNull('document_approved_at')
        ->with(['establishment', 'approvedByUser'])
        ->orderByDesc('document_approved_at')
        ->paginate(10);

        return view('vendor.establishments.documents.approved', compact('approvedDocuments'));
    }

    /**
     * Exibe a lista de documentos rejeitados
     */
    public function rejected()
    {
        $vendor = Auth::guard('vendor')->user();

        $rejectedDocuments = EstablishmentOnboarding::whereHas('establishment', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })
        ->whereNotNull('document_path')
        ->where('document_approved', false)
        ->whereNotNull('document_approved_at')
        ->with(['establishment', 'approvedByUser'])
        ->orderByDesc('document_approved_at')
        ->paginate(10);

        return view('vendor.establishments.documents.rejected', compact('rejectedDocuments'));
    }

    /**
     * Exibe o formulário para upload de documento (Vendor)
     */
    public function showUploadForm(Establishment $establishment)
    {
        // Autoriza o vendor a ver/atualizar o estabelecimento
        $this->authorize('update', $establishment);

        $onboarding = $establishment->onboarding()->first();

        return view('vendor.establishments.documents.upload', compact('establishment', 'onboarding'));
    }

    /**
     * Processa o upload do documento (Vendor)
     */
    public function handleUpload(Request $request, Establishment $establishment)
    {
        // Autoriza o vendor a atualizar o estabelecimento
        $this->authorize('update', $establishment);

        $validator = Validator::make($request->all(), [
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
        ], [
            'document.required' => 'É necessário enviar um documento.',
            'document.file' => 'O arquivo enviado é inválido.',
            'document.mimes' => 'O documento deve ser um arquivo PDF, JPG, JPEG ou PNG.',
            'document.max' => 'O documento não pode ter mais de 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $onboarding = $establishment->onboarding()->firstOrCreate(
            ['establishment_id' => $establishment->id],
            [
                'token' => \Illuminate\Support\Str::random(64),
                'expires_at' => now()->addYear()
            ]
        );

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $file = $request->file('document');
            $fileName = 'establishment_' . $establishment->id . '_doc_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents/establishments', $fileName, 'private');

            if ($onboarding->document_path && Storage::disk('private')->exists($onboarding->document_path)) {
                Storage::disk('private')->delete($onboarding->document_path);
            }

            $onboarding->document_path = $filePath;
            $onboarding->document_approved = false; // Documento enviado pelo vendor sempre fica pendente
            $onboarding->document_approved_at = null;
            $onboarding->approved_by_user_id = null;
            $onboarding->approval_notes = null;
            $onboarding->save();

            return redirect()->route('vendor.establishments.index')
                ->with('success', 'Documento do estabelecimento ' . $establishment->nome . ' enviado com sucesso! Aguardando aprovação do administrador.');
        }

        return redirect()->back()->with('error', 'Falha ao fazer upload do documento.');
    }
}
