<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstablishmentOnboarding;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\DocumentRejectedMail;

class DocumentApprovalController extends Controller
{
    /**
     * Exibe a lista de todos os documentos
     */
    public function index(Request $request)
    {
        $query = EstablishmentOnboarding::whereNotNull('document_path')
            ->with('establishment.vendor');

        // Filtro por status
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('document_approved', false)
                      ->whereNull('document_approved_at');
            } elseif ($request->status === 'approved') {
                $query->where('document_approved', true);
            } elseif ($request->status === 'rejected') {
                $query->where('document_approved', false)
                      ->whereNotNull('document_approved_at');
            }
        }

        // Filtro por nome do estabelecimento
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('establishment', function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%");
            });
        }

        $allDocuments = $query->orderBy('completed_at', 'desc')
            ->paginate(config('project.per_page'))
            ->withQueryString();

        return view('admin.documents.index', compact('allDocuments'));
    }

    /**
     * Exibe a lista de documentos pendentes
     */
    public function pending()
    {
        $pendingDocuments = EstablishmentOnboarding::whereNotNull('document_path')
            ->where('document_approved', false)
            ->whereNull('document_approved_at')
            ->with('establishment.vendor')
            ->orderBy('completed_at', 'asc')
            ->paginate(config('project.per_page'));

        return view('admin.documents.pending', compact('pendingDocuments'));
    }

    /**
     * Exibe a lista de documentos já aprovados
     */
    public function approved()
    {
        $approvedDocuments = EstablishmentOnboarding::where('document_approved', true)
            ->whereNotNull('document_approved_at')
            ->whereNotNull('document_path')
            ->with(['establishment.vendor', 'approvedByUser'])
            ->orderByDesc('document_approved_at')
            ->paginate(config('project.per_page'));

        return view('admin.documents.approved', compact('approvedDocuments'));
    }

    /**
     * Exibe a lista de documentos rejeitados
     */
    public function rejected()
    {
        $rejectedDocuments = EstablishmentOnboarding::where('document_approved', false)
            ->whereNotNull('document_approved_at')
            ->whereNotNull('document_path')
            ->with(['establishment.vendor', 'approvedByUser'])
            ->orderByDesc('document_approved_at')
            ->paginate(config('project.per_page'));

        return view('admin.documents.rejected', compact('rejectedDocuments'));
    }

    /**
     * Exibe os detalhes de um documento para aprovação
     */
    public function show(EstablishmentOnboarding $onboarding)
    {
        if (!$onboarding->document_path) {
            return redirect()->route('admin.establishments.documents.index')
                ->with('error', 'Este registro de onboarding não possui documento para visualização.');
        }
        return view('admin.documents.show', compact('onboarding'));
    }

    /**
     * Visualiza/Baixa o documento enviado pelo estabelecimento
     */
    public function viewDocument(EstablishmentOnboarding $onboarding)
    {
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
     * Aprova o documento de um estabelecimento
     */
    public function approve(Request $request, EstablishmentOnboarding $onboarding)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $onboarding->approveDocument(Auth::id(), $validated['notes'] ?? null);

        return redirect()->route('admin.establishments.documents.index')
            ->with('success', 'Documento aprovado com sucesso!');
    }

    /**
     * Rejeita o documento de um estabelecimento
     */
    public function reject(Request $request, EstablishmentOnboarding $onboarding)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $onboarding->update([
            'document_approved' => false,
            'document_approved_at' => now(),
            'document_approved_by' => Auth::id(),
            'approval_notes' => $request->notes
        ]);

        // Notificação removida para simplificar - implementar conforme necessário

        return redirect()->route('admin.establishments.documents.pending')
                         ->with('success', 'Documento rejeitado com sucesso!');
    }

    /**
     * Exibe o formulário para upload de documento
     */
    public function showUploadForm(Establishment $establishment)
    {
        $onboarding = $establishment->onboarding()->first();

        return view('admin.documents.upload', compact('establishment', 'onboarding'));
    }

    /**
     * Processa o upload do documento
     */
    public function handleUpload(Request $request, Establishment $establishment)
    {
        $validator = Validator::make($request->all(), [
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
            $onboarding->document_approved = false;
            $onboarding->document_approved_at = null;
            $onboarding->approved_by_user_id = null;
            $onboarding->approval_notes = null;
            $onboarding->save();

            return redirect()->route('admin.establishments.index')
                ->with('success', 'Documento do estabelecimento ' . $establishment->nome . ' enviado com sucesso! Aguardando aprovação.');
        }

        return redirect()->back()->with('error', 'Falha ao fazer upload do documento.');
    }

    /**
     * Remove the specified document from storage.
     *
     * @param  \App\Models\Onboarding  $onboarding
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstablishmentOnboarding $onboarding)
    {
        try {
            // Remove the document file from storage
            if ($onboarding->document_path && Storage::exists($onboarding->document_path)) {
                Storage::delete($onboarding->document_path);
            }

            // Reset document fields
            $onboarding->update([
                'document_path' => null,
                'document_approved' => null,
                'document_approved_at' => null,
                'document_approved_by' => null,
                'approval_notes' => null,
                'completed_at' => null
            ]);

            return redirect()->back()->with('success', 'Documento excluído com sucesso.');
        } catch (\Exception $e) {
            Log::error('Error deleting document: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao excluir documento: ' . $e->getMessage());
        }
    }
}
