<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cliente::with('criadoPorAdmin');

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'nome');
        if (in_array($orderBy, ['nome', 'email', 'created_at', 'status'])) {
            $query->orderBy($orderBy, $orderBy === 'nome' ? 'asc' : 'desc');
        }

        $clientes = $query->paginate(15);

        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'cpf' => 'required|string|size:11|unique:clientes,cpf',
            'telefone' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'limite_total' => 'required|numeric|min:0',
            'status' => 'required|in:ativo,bloqueado,pendente',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['criado_por_admin_id'] = Auth::id();
        $data['limite_disponivel'] = $request->limite_total;

        Cliente::create($data);

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('clientes')->ignore($cliente->id)],
            'cpf' => ['required', 'string', 'size:11', Rule::unique('clientes')->ignore($cliente->id)],
            'telefone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6|confirmed',
            'limite_total' => 'required|numeric|min:0',
            'status' => 'required|in:ativo,bloqueado,pendente',
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Ajustar limite disponível se o total mudou
        if ($request->limite_total != $cliente->limite_total) {
            $diferenca = $request->limite_total - $cliente->limite_total;
            $data['limite_disponivel'] = $cliente->limite_disponivel + $diferenca;
        }

        $cliente->update($data);

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar se o cliente tem estabelecimentos vinculados
        if ($cliente->estabelecimentos()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Não é possível excluir um cliente que possui estabelecimentos vinculados.');
        }

        $cliente->delete();

        return redirect()
            ->route('admin.clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
