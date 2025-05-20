<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nome', 'like', "%{$search}%");
        }

        // Ordenação
        $orderBy = $request->order_by ?? 'nome'; // Default to 'nome'
        $orderDirection = 'asc'; // Default direction

        // Se quiser inverter a direção para 'created_at' ou 'id' para mostrar mais recentes primeiro
        // if (in_array($orderBy, ['id', 'created_at'])) {
        //     $orderDirection = 'desc';
        // }

        $query->orderBy($orderBy, $orderDirection);

        $categories = $query->paginate(config('project.per_page'))->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categories,nome',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:categories,nome,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Verificar se existem estabelecimentos usando esta categoria
        if ($category->establishments()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Não é possível excluir esta categoria pois existem estabelecimentos vinculados a ela.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
