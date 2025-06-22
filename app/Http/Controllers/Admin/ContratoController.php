<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Usuario;
use App\Services\ContratoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
{
    protected $contratoService;

    public function __construct(ContratoService $contratoService)
    {
        $this->contratoService = $contratoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contrato::with(['usuario']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_contrato', 'like', "%{$search}%")
                  ->orWhereHas('usuario', function($uq) use ($search) {
                      $uq->where('nome', 'like', "%{$search}%")
                        ->orWhere('cpf', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'created_at');
        if (in_array($orderBy, ['created_at', 'numero_contrato', 'status'])) {
            $query->orderBy($orderBy, 'desc');
        }

        $contratos = $query->paginate(15);

        return view('admin.contratos.index', compact('contratos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $usuarioId = $request->get('usuario_id');
        $usuario = null;

        if ($usuarioId) {
            $usuario = Usuario::findOrFail($usuarioId);

            // Verificar se já tem contrato
            if ($usuario->contrato) {
                return redirect()
                    ->route('admin.usuarios.show', $usuario)
                    ->with('error', 'Este usuário já possui um contrato.');
            }
        }

        // Buscar todos os clientes que não têm contrato
        $clientes = Usuario::whereDoesntHave('contrato')->orderBy('nome')->get();
        $tabelaReferencia = $this->contratoService->tabelaReferenciaScores();

        return view('admin.contratos.create', compact('usuario', 'clientes', 'tabelaReferencia'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'tipo' => 'required|in:site,avulso',
            'documento_identidade' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'score_inicial' => 'nullable|integer|min:0|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $usuario = Usuario::findOrFail($request->usuario_id);

            // Verificar se já tem contrato
            if ($usuario->contrato) {
                return redirect()
                    ->back()
                    ->with('error', 'Este usuário já possui um contrato.');
            }

            $dadosContrato = [
                'tipo' => $request->tipo,
                'documento_identidade' => $request->file('documento_identidade'),
                'score_inicial' => $request->score_inicial,
            ];

            $contrato = $this->contratoService->criarContrato($usuario, $dadosContrato);

            DB::commit();

            return redirect()
                ->route('admin.contratos.show', $contrato)
                ->with('success', 'Contrato criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Erro ao criar contrato: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contrato $contrato)
    {
        $contrato->load(['usuario', 'usuario.adminLimiteAprovadoPor']);

        return view('admin.contratos.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contrato $contrato)
    {
        $contrato->load('usuario');

        return view('admin.contratos.edit', compact('contrato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contrato $contrato)
    {
        $request->validate([
            'protocolo_cpfl' => 'nullable|string|max:255',
            'protocolo_cancelamento' => 'nullable|string|max:255',
            'status' => 'required|in:pendente_cpfl,ativo,cancelado',
        ]);

        $contrato->update($request->only([
            'protocolo_cpfl',
            'protocolo_cancelamento',
            'status'
        ]));

        return redirect()
            ->route('admin.contratos.show', $contrato)
            ->with('success', 'Contrato atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contrato $contrato)
    {
        if ($contrato->status === Contrato::STATUS_ATIVO) {
            return redirect()
                ->back()
                ->with('error', 'Não é possível excluir um contrato ativo.');
        }

        $contrato->delete();

        return redirect()
            ->route('admin.contratos.index')
            ->with('success', 'Contrato excluído com sucesso!');
    }

    /**
     * Mostrar formulário para definir limite
     */
    public function definirLimite(Usuario $usuario)
    {
        // Verificar se o usuário tem contrato
        if (!$usuario->contrato) {
            return redirect()
                ->route('admin.usuarios.show', $usuario)
                ->with('error', 'Usuário não possui contrato.');
        }

        $limiteSugerido = 0;
        if ($usuario->score_atual) {
            $limiteSugerido = $this->contratoService->calcularLimitePorScore($usuario->score_atual);
        }

        $tabelaReferencia = $this->contratoService->tabelaReferenciaScores();

        return view('admin.contratos.definir-limite', compact('usuario', 'limiteSugerido', 'tabelaReferencia'));
    }

    /**
     * Salvar limite definido
     */
    public function salvarLimite(Request $request, Usuario $usuario)
    {
        $request->validate([
            'limite_credito_manual' => 'required|numeric|min:0',
            'motivo_limite_manual' => 'required_if:limite_diferente,true|nullable|string|max:500',
        ]);

        $limite = $request->limite_credito_manual;
        $limiteSugerido = $usuario->limite_credito_sugerido ?? 0;
        $motivo = null;

        // Se o limite é diferente do sugerido, exigir justificativa
        if ($limite != $limiteSugerido) {
            $request->validate([
                'motivo_limite_manual' => 'required|string|max:500',
            ], [
                'motivo_limite_manual.required' => 'Justificativa é obrigatória quando o limite é diferente do sugerido.'
            ]);

            $motivo = $request->motivo_limite_manual;
        }

        $this->contratoService->definirLimiteManual(
            $usuario,
            $limite,
            $motivo,
            Auth::id()
        );

        return redirect()
            ->route('admin.usuarios.show', $usuario)
            ->with('success', 'Limite definido com sucesso!');
    }

    /**
     * Ativar contrato
     */
    public function ativar(Request $request, Contrato $contrato)
    {
        $request->validate([
            'protocolo_cpfl' => 'required|string|max:255',
        ]);

        $this->contratoService->ativarContrato($contrato, $request->protocolo_cpfl);

        return redirect()
            ->route('admin.contratos.show', $contrato)
            ->with('success', 'Contrato ativado com sucesso!');
    }

    /**
     * Cancelar contrato
     */
    public function cancelar(Request $request, Contrato $contrato)
    {
        $request->validate([
            'protocolo_cancelamento' => 'nullable|string|max:255',
        ]);

        try {
            $this->contratoService->cancelarContrato($contrato, $request->protocolo_cancelamento);

            return redirect()
                ->route('admin.contratos.show', $contrato)
                ->with('success', 'Contrato cancelado com sucesso!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Relatório de usuários para revisão de score
     */
    public function revisaoScore()
    {
        $usuarios = $this->contratoService->usuariosParaRevisaoScore();

        return view('admin.contratos.revisao-score', compact('usuarios'));
    }
}
