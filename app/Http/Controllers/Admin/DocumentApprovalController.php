<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstablishmentOnboarding;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentApprovalController extends Controller
{
    /**
     * Exibe a lista de todos os documentos
     */
    public function index()
    {
        $allDocuments = EstablishmentOnboarding::where('completed', true)
            ->where('document_path', '!=', null)
            ->with('establishment.vendor')
            ->orderBy('completed_at', 'desc')
            ->paginate(10);

        return view('admin.documents.index', compact('allDocuments'));
    }

    /**
     * Exibe a lista de documentos pendentes de aprovação
     */
    public function pending()
    {
        $pendingDocuments = EstablishmentOnboarding::where('completed', true)
            ->where('document_path', '!=', null)
            ->where('document_approved', false)
            ->whereNull('document_approved_at')
            ->with('establishment.vendor')
            ->orderBy('completed_at')
            ->paginate(10);

        return view('admin.documents.pending', compact('pendingDocuments'));
    }

    /**
     * Exibe a lista de documentos já aprovados
     */
    public function approved()
    {
        $approvedDocuments = EstablishmentOnboarding::where('completed', true)
            ->where('document_path', '!=', null)
            ->where('document_approved', true)
            ->whereNotNull('document_approved_at')
            ->with(['establishment.vendor', 'approvedByUser'])
            ->orderByDesc('document_approved_at')
            ->paginate(10);

        return view('admin.documents.approved', compact('approvedDocuments'));
    }

    /**
     * Exibe a lista de documentos rejeitados
     */
    public function rejected()
    {
        $rejectedDocuments = EstablishmentOnboarding::where('completed', true)
            ->where('document_path', '!=', null)
            ->where('document_approved', false)
            ->whereNotNull('document_approved_at')
            ->with(['establishment.vendor', 'approvedByUser'])
            ->orderByDesc('document_approved_at')
            ->paginate(10);

        return view('admin.documents.rejected', compact('rejectedDocuments'));
    }

    /**
     * Exibe os detalhes de um documento para aprovação
     */
    public function show(EstablishmentOnboarding $onboarding)
    {
        return view('admin.documents.show', compact('onboarding'));
    }

    /**
     * Visualiza o documento enviado pelo estabelecimento
     */
    public function viewDocument(EstablishmentOnboarding $onboarding)
    {
        if (!$onboarding->document_path) {
            return redirect()->back()->with('error', 'Este estabelecimento não enviou nenhum documento.');
        }

        return Storage::disk('private')->response($onboarding->document_path);
    }

    /**
     * Aprova o documento de um estabelecimento
     */
    public function approve(Request $request, EstablishmentOnboarding $onboarding)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $onboarding->approveDocument(Auth::id(), $validated['notes'] ?? null);

        return redirect()->route('admin.establishments.documents.pending')
            ->with('success', 'Documento aprovado com sucesso!');
    }

    /**
     * Rejeita o documento de um estabelecimento
     */
    public function reject(Request $request, EstablishmentOnboarding $onboarding)
    {
        $validated = $request->validate([
            'notes' => 'required|string|max:1000',
        ], [
            'notes.required' => 'É necessário informar o motivo da rejeição.',
        ]);

        $onboarding->rejectDocument(Auth::id(), $validated['notes']);

        return redirect()->route('admin.establishments.documents.pending')
            ->with('success', 'Documento rejeitado com sucesso!');
    }
}