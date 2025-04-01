<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\EstablishmentOnboarding;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EstablishmentDocumentController extends Controller
{
    /**
     * Construtor
     */
    public function __construct()
    {
        $this->middleware('auth:vendor');
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
        ->where('completed', true)
        ->where('document_path', '!=', null)
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

        // Garantir que o modelo Establishment está sendo usado corretamente
        abort_unless($onboarding->establishment->vendor_id === auth()->id(), 403);

        return view('vendor.establishments.documents.show', compact('onboarding'));
    }

    /**
     * Visualiza o documento enviado pelo estabelecimento
     */
    public function viewDocument(EstablishmentOnboarding $onboarding)
    {
        // Verificar se o onboarding pertence a um estabelecimento do vendedor logado
        $this->authorize('view', $onboarding->establishment);

        // Garantir que o modelo Establishment está sendo usado corretamente
        abort_unless($onboarding->establishment->vendor_id === auth()->id(), 403);

        if (!$onboarding->document_path) {
            return redirect()->back()->with('error', 'Este estabelecimento não enviou nenhum documento.');
        }

        return Storage::disk('private')->response($onboarding->document_path);
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
        ->where('completed', true)
        ->where('document_path', '!=', null)
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
        ->where('completed', true)
        ->where('document_path', '!=', null)
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
        ->where('completed', true)
        ->where('document_path', '!=', null)
        ->where('document_approved', false)
        ->whereNotNull('document_approved_at')
        ->with(['establishment', 'approvedByUser'])
        ->orderByDesc('document_approved_at')
        ->paginate(10);

        return view('vendor.establishments.documents.rejected', compact('rejectedDocuments'));
    }
}