<?php

namespace App\Http\Controllers;

use App\Models\EstablishmentOnboarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class EstablishmentOnboardingController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Exibe o formulário de onboarding para o estabelecimento
     */
    public function show(string $token)
    {
        // Busca o onboarding pelo token
        $onboarding = EstablishmentOnboarding::where('token', $token)
            ->with('establishment')
            ->first();

        // Verifica se o onboarding existe
        if (!$onboarding) {
            return redirect()->route('site.index')
                ->with('error', 'Link inválido ou expirado.');
        }

        // Verifica se o onboarding já foi concluído
        if ($onboarding->isCompleted()) {
            return redirect()->route('site.index')
                ->with('info', 'Seu cadastro já foi concluído. Obrigado!');
        }

        // Verifica se o onboarding expirou
        if ($onboarding->isExpired()) {
            return redirect()->route('site.index')
                ->with('error', 'Este link expirou. Entre em contato com o suporte.');
        }

        // Retorna a view com os dados do onboarding
        return view('establishment.onboarding', [
            'onboarding' => $onboarding,
            'establishment' => $onboarding->establishment
        ]);
    }

    /**
     * Processa o formulário de onboarding
     */
    public function process(Request $request, string $token)
    {
        // Busca o onboarding pelo token
        $onboarding = EstablishmentOnboarding::where('token', $token)
            ->with('establishment')
            ->first();

        // Verifica se o onboarding existe
        if (!$onboarding) {
            return redirect()->route('site.index')
                ->with('error', 'Link inválido ou expirado.');
        }

        // Verifica se o onboarding já foi concluído
        if ($onboarding->isCompleted()) {
            return redirect()->route('site.index')
                ->with('info', 'Seu cadastro já foi concluído. Obrigado!');
        }

        // Verifica se o onboarding expirou
        if ($onboarding->isExpired()) {
            return redirect()->route('site.index')
                ->with('error', 'Este link expirou. Entre em contato com o suporte.');
        }

        // Valida os dados do formulário
        $validator = Validator::make($request->all(), [
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
            'contract_accepted' => 'required|accepted',
        ], [
            'document.required' => 'É necessário enviar um documento.',
            'document.file' => 'O arquivo enviado é inválido.',
            'document.mimes' => 'O documento deve ser um arquivo PDF, JPG, JPEG ou PNG.',
            'document.max' => 'O documento não pode ter mais de 5MB.',
            'contract_accepted.required' => 'É necessário aceitar o contrato.',
            'contract_accepted.accepted' => 'É necessário aceitar o contrato.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Processa o upload do documento
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $file = $request->file('document');
            $fileName = 'establishment_' . $onboarding->establishment_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents/establishments', $fileName, 'private');

            // Atualiza o onboarding com o caminho do documento
            $onboarding->document_path = $filePath;
        }

        // Atualiza o onboarding com os dados do aceite do contrato
        $onboarding->contract_accepted = true;
        $onboarding->contract_accepted_at = now();
        $onboarding->ip_address = $request->ip();
        $onboarding->completed = true;
        $onboarding->completed_at = now();
        $onboarding->save();

        // Redireciona para a página de sucesso
        return redirect()->route('establishment.onboarding.success', ['token' => $token]);
    }

    /**
     * Exibe a página de sucesso após o onboarding
     */
    public function success(string $token)
    {
        // Busca o onboarding pelo token
        $onboarding = EstablishmentOnboarding::where('token', $token)
            ->with('establishment')
            ->first();

        // Verifica se o onboarding existe e foi concluído
        if (!$onboarding || !$onboarding->isCompleted()) {
            return redirect()->route('site.index');
        }

        // Retorna a view de sucesso
        return view('establishment.success', [
            'establishment' => $onboarding->establishment
        ]);
    }
}