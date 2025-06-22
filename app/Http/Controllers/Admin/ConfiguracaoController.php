<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configuracoes = Configuracao::orderBy('chave')->get()->groupBy(function ($item) {
            return $this->getGrupoConfiguracao($item->chave);
        });

        return view('admin.configuracoes.index', compact('configuracoes'));
    }

    /**
     * Store/Update all configurations at once.
     */
    public function store(Request $request)
    {
        $configuracoes = Configuracao::all();

        foreach ($configuracoes as $config) {
            $fieldName = 'config_' . $config->id;

            if ($request->has($fieldName)) {
                $config->update([
                    'valor' => $request->input($fieldName)
                ]);
            }
        }

        return redirect()
            ->route('admin.configuracoes.index')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }

    /**
     * Update the specified configuration.
     */
    public function update(Request $request, Configuracao $configuracao)
    {
        $request->validate([
            'valor' => 'required|string|max:255',
        ]);

        $configuracao->update([
            'valor' => $request->valor
        ]);

        return redirect()
            ->route('admin.configuracoes.index')
            ->with('success', 'Configuração atualizada com sucesso!');
    }

    /**
     * Determina o grupo da configuração baseado na chave
     */
    private function getGrupoConfiguracao($chave)
    {
        if (str_contains($chave, 'cpfl')) {
            return 'CPFL';
        }

        if (str_contains($chave, 'credito') || str_contains($chave, 'juros')) {
            return 'Sistema de Crédito';
        }

        if (str_contains($chave, 'score')) {
            return 'Score e Limites';
        }

        return 'Geral';
    }
}
