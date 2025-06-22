<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastroSiteRequest;
use App\Models\Cliente;
use App\Mail\CadastroSiteMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{
    /**
     * Exibe a página inicial do site
     */
    public function index()
    {
        return view('site.index');
    }

    /**
     * Exibe a página de cadastro
     */
    public function cadastro()
    {
        return view('site.cadastro');
    }

    /**
     * Processa o formulário de cadastro
     */
    public function cadastroStore(CadastroSiteRequest $request)
    {
        try {
            // Limpar formatação dos dados
            $dadosLimpos = [
                'nome' => $request->input('name'),
                'email' => $request->input('email'),
                'cpf' => preg_replace('/\D/', '', $request->input('cpf')),
                'telefone' => preg_replace('/\D/', '', $request->input('phone')),
                'cep' => preg_replace('/\D/', '', $request->input('cep')),
                'endereco' => $request->input('address'),
                'cidade' => $request->input('city'),
                'estado' => $request->input('state'),
                'conta_cpfl' => $request->input('cpflCode'),
                'password' => Hash::make($request->input('password')),
                'status' => 'pendente',
                'criado_por_admin_id' => 1, // ID do admin padrão - ajustar conforme necessário
            ];

            // Salvar na tabela clientes
            $cliente = Cliente::create($dadosLimpos);

            // Log dos dados recebidos (sem a senha por segurança)
            $logData = $dadosLimpos;
            unset($logData['password']);
            Log::info('Novo cliente cadastrado pelo site', [
                'cliente_id' => $cliente->id,
                'data' => $logData
            ]);

            // Enviar e-mail de confirmação
            try {
                Mail::to($cliente->email)->send(new CadastroSiteMail($cliente));
                Log::info('Email de confirmação enviado', ['cliente_id' => $cliente->id]);
            } catch (\Exception $e) {
                Log::error('Erro ao enviar email de confirmação', [
                    'cliente_id' => $cliente->id,
                    'error' => $e->getMessage()
                ]);
                // Continua mesmo se o email falhar
            }

            // Redirecionar para página de sucesso
            return redirect()->route('site.cadastro.sucesso')
                           ->with('cliente_email', $cliente->email);

        } catch (\Exception $e) {
            Log::error('Erro ao processar cadastro', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->route('site.cadastro')
                           ->with('error', 'Ocorreu um erro ao processar seu cadastro. Tente novamente.')
                           ->withInput();
        }
    }

    /**
     * Exibe a página de sucesso do cadastro
     */
    public function cadastroSucesso()
    {
        if (!session('cadastro_id')) {
            return redirect()->route('site.cadastro');
        }

        $cadastroId = session('cadastro_id');
        return view('site.cadastro-sucesso', compact('cadastroId'));
    }

    /**
     * Exibe a página de termos de uso
     */
    public function termosDeUso()
    {
        return view('site.termos-de-uso');
    }

    /**
     * Exibe a página de política de privacidade
     */
    public function politicaPrivacidade()
    {
        return view('site.politica-privacidade');
    }

    /**
     * Exibe a página de contato
     */
    public function contato()
    {
        return view('site.contato');
    }

    /**
     * Processa o formulário de contato
     */
    public function contatoStore(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Aqui você pode implementar o envio do email ou salvar no banco
            Log::info('Nova mensagem de contato recebida', [
                'nome' => $request->name,
                'email' => $request->email,
                'assunto' => $request->subject,
                'mensagem' => $request->message,
            ]);

            return redirect()->route('site.contato')
                           ->with('success', 'Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.');

        } catch (\Exception $e) {
            Log::error('Erro ao processar formulário de contato', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->route('site.contato')
                           ->with('error', 'Ocorreu um erro ao enviar sua mensagem. Tente novamente.')
                           ->withInput();
        }
    }

    /**
     * Exibe a página da rede credenciada
     */
    public function redeCredenciada()
    {
        return view('site.rede-credenciada');
    }

    /**
     * Exibe a página da central de ajuda
     */
    public function centralAjuda()
    {
        return view('site.central-ajuda');
    }

    /**
     * Exibe a página de suporte
     */
    public function suporte()
    {
        return view('site.suporte');
    }
}
