<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'name');
        if (in_array($orderBy, ['name', 'email', 'created_at'])) {
            $query->orderBy($orderBy, $orderBy === 'name' ? 'asc' : 'desc');
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Administrador cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Administrador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Não permitir excluir o usuário principal (ID 1)
        if ($user->id === 1) {
            return redirect()
                ->back()
                ->with('error', 'Não é possível excluir o administrador principal.');
        }

        // Não permitir que o usuário exclua a si mesmo
        if ($user->id === Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'Você não pode excluir sua própria conta.');
        }

        // Verificar se há pelo menos um administrador restante
        if (User::count() <= 1) {
            return redirect()
                ->back()
                ->with('error', 'Deve haver pelo menos um administrador no sistema.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Administrador excluído com sucesso!');
    }

    /**
     * Show access logs for a user (placeholder)
     */
    public function accessLogs(User $user)
    {
        // Implementar se necessário
        return redirect()->route('admin.users.index')
            ->with('info', 'Funcionalidade de logs de acesso em desenvolvimento.');
    }
}
