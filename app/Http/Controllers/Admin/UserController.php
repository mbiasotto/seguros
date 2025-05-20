<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\AdminWelcome; // Add this import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Busca por nome ou email
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $orderBy = $request->order_by ?? 'name';
        $query->orderBy($orderBy, 'asc');

        $users = $query->paginate(config('project.per_page'));

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Guarda a senha não criptografada para o email
        $plainPassword = $request->password;

        $validated['password'] = Hash::make($request->password);
        $user = User::create($validated);

        // Enviar e-mail de boas-vindas
        try {
            $this->sendWelcomeEmail($user, $plainPassword);

            // Log de sucesso
            Log::info('E-mail de boas-vindas enviado com sucesso', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            // Log do erro, mas não impede o cadastro
            Log::error('Erro ao enviar e-mail de boas-vindas para admin: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        // Mensagem de sucesso genérica
        return redirect()->route('admin.users.index')
            ->with('success', 'Administrador cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $isMainAdmin = ($user->id === 1);
        return view('admin.users.edit', compact('user', 'isMainAdmin'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Se uma nova senha foi fornecida
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrador atualizado com sucesso!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Impedir que o admin com ID 1 seja excluído
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'O administrador principal não pode ser excluído.');
        }

        // Evitar que o último administrador seja excluído
        if (User::count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Não é possível excluir o último administrador.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrador excluído com sucesso!');
    }

    /**
     * Envia email de boas-vindas para o administrador
     */
    private function sendWelcomeEmail(User $user, string $plainPassword)
    {
        // Log antes de enviar o e-mail
        Log::info('Iniciando envio de e-mail para administrador', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        // Use the new Mailable class
        Mail::to($user->email)->send(new AdminWelcome($user, $plainPassword));

        // Log depois de enviar o e-mail (mantém o log)
        Log::info('E-mail enviado com sucesso', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);
    }

    /**
     * Exibe o histórico de acessos do administrador
     */
    public function accessLogs(User $user)
    {
        $accessLogs = $user->accessLogs()->orderBy('created_at', 'desc')->paginate(config('project.per_page'));
        return view('admin.users.access-logs', compact('user', 'accessLogs'));
    }
}
