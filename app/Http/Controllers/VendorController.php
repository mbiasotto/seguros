<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Services\Email\EmailServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VendorController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Serviço de e-mail
     */
    private EmailServiceInterface $emailService;

    public function __construct(EmailServiceInterface $emailService)
    {
        $this->middleware('auth');
        $this->emailService = $emailService;
    }

    /**
     * Envia e-mail de boas-vindas para o novo vendedor
     */
    private function sendWelcomeEmail(Vendor $vendor)
    {
        try {
            // Utiliza o serviço de e-mail para enviar o template
            return $this->emailService->sendTemplate(
                $vendor->email,
                $vendor->nome,
                'Bem-vindo ao SeguraEssa.app - Informações de Acesso',
                'emails.vendor-welcome',
                ['vendor' => $vendor]
            );
        } catch (\Exception $e) {
            throw new \Exception('Erro ao enviar e-mail: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $vendors = Vendor::orderBy('nome')->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6|confirmed',
            'telefone' => 'required',
            'endereco' => 'nullable|max:255',
            'cidade' => 'nullable|max:255',
            'estado' => 'nullable|max:2',
            'cep' => 'nullable|max:9',
            'observacoes' => 'nullable',
            'ativo' => 'boolean'
        ]);

        $validated['password'] = Hash::make($request->password);
        $vendor = Vendor::create($validated);

        // Enviar e-mail de boas-vindas
        try {
            $this->sendWelcomeEmail($vendor);
        } catch (\Exception $e) {
            // Log do erro, mas não impede o cadastro
            Log::error('Erro ao enviar e-mail de boas-vindas: ' . $e->getMessage());
        }

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendedor cadastrado com sucesso!');
    }

    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'telefone' => 'required',
            'endereco' => 'nullable|max:255',
            'cidade' => 'nullable|max:255',
            'estado' => 'nullable|max:2',
            'cep' => 'nullable|max:9',
            'observacoes' => 'nullable',
            'ativo' => 'boolean'
        ]);

        $vendor->update($validated);
        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendedor atualizado com sucesso!');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendedor removido com sucesso!');
    }

    /**
     * Exibe o histórico de acessos do vendedor
     */
    public function accessLogs(Vendor $vendor)
    {
        $accessLogs = $vendor->accessLogs()->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.vendors.access-logs', compact('vendor', 'accessLogs'));
    }
}
