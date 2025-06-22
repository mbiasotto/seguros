<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estabelecimento;
use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminEstabelecimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Estabelecimento::with(['categoria', 'criadoPorAdmin']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                  ->orWhere('nome_fantasia', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('categoria_id', $request->category_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'ativo');
            } elseif ($request->status === 'inactive') {
                $query->where('status', '!=', 'ativo');
            }
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'id');
        if (in_array($orderBy, ['id', 'razao_social', 'cidade', 'created_at'])) {
            $query->orderBy($orderBy, $orderBy === 'razao_social' ? 'asc' : 'desc');
        }

        $establishments = $query->paginate(15);
        $categories = Categoria::orderBy('nome')->get();
        $clientes = Cliente::orderBy('nome')->get();

        return view('admin.establishments.index', compact('establishments', 'categories', 'clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categoria::orderBy('nome')->get();
        return view('admin.establishments.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cnpj' => 'required|string|unique:estabelecimentos,cnpj',
            'email' => 'required|email|unique:estabelecimentos,email',
            'telefone' => 'required|string',
            'endereco' => 'required|string',
            'numero' => 'nullable|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'status' => 'required|in:ativo,bloqueado,pendente',
        ]);

        $dados = $request->all();
        $dados['criado_por_admin_id'] = Auth::id();
        $dados['password'] = Hash::make('123456'); // Senha padrão

        Estabelecimento::create($dados);

        return redirect()
            ->route('admin.establishments.index')
            ->with('success', 'Estabelecimento cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estabelecimento $establishment)
    {
        $categories = Categoria::orderBy('nome')->get();
        return view('admin.establishments.edit', compact('establishment', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estabelecimento $establishment)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cnpj' => 'required|string|unique:estabelecimentos,cnpj,' . $establishment->id,
            'email' => 'required|email|unique:estabelecimentos,email,' . $establishment->id,
            'telefone' => 'required|string',
            'endereco' => 'required|string',
            'numero' => 'nullable|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'status' => 'required|in:ativo,bloqueado,pendente',
        ]);

        $dados = $request->all();

        $establishment->update($dados);

        return redirect()
            ->route('admin.establishments.index')
            ->with('success', 'Estabelecimento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estabelecimento $establishment)
    {
        $establishment->delete();

        return redirect()
            ->route('admin.establishments.index')
            ->with('success', 'Estabelecimento excluído com sucesso!');
    }
}
