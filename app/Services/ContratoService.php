<?php

namespace App\Services;

use App\Models\Contrato;
use App\Models\Usuario;
use App\Models\Configuracao;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ContratoService
{
    /**
     * Criar um novo contrato
     */
    public function criarContrato(Usuario $usuario, array $dadosContrato): Contrato
    {
        // Gerar número único do contrato
        $numeroContrato = $this->gerarNumeroContrato();

        // Gerar número único do cartão
        $numeroCartao = $this->gerarNumeroCartao();

        // Definir validade do cartão (3 anos)
        $validadeCartao = Carbon::now()->addYears(3);

        // Calcular limite baseado no score (se fornecido)
        $limiteSugerido = 0;
        if (isset($dadosContrato['score_inicial'])) {
            $limiteSugerido = $this->calcularLimitePorScore($dadosContrato['score_inicial']);
        }

        // Agendar revisão de score (180 dias)
        $dataProximaRevisao = Carbon::now()->addDays(Configuracao::prazoRevisaoScoreDias());

        // Upload do documento de identidade
        $documentoUrl = null;
        if (isset($dadosContrato['documento_identidade']) && $dadosContrato['documento_identidade'] instanceof UploadedFile) {
            $documentoUrl = $this->uploadDocumentoIdentidade($dadosContrato['documento_identidade'], $usuario);
        }

        // Criar o contrato
        $contrato = Contrato::create([
            'usuario_id' => $usuario->id,
            'numero_contrato' => $numeroContrato,
            'tipo' => $dadosContrato['tipo'],
            'documento_identidade_url' => $documentoUrl,
            'score_inicial' => $dadosContrato['score_inicial'] ?? null,
            'limite_inicial' => $limiteSugerido,
            'data_proxima_revisao_score' => $dataProximaRevisao,
        ]);

        // Atualizar dados do usuário
        $usuario->update([
            'numero_cartao' => $numeroCartao,
            'validade_cartao' => $validadeCartao,
            'limite_credito_sugerido' => $limiteSugerido,
            'score_atual' => $dadosContrato['score_inicial'] ?? null,
            'data_ultima_consulta_score' => now(),
        ]);

        return $contrato;
    }

    /**
     * Calcular limite de crédito baseado no score
     */
    public function calcularLimitePorScore(int $score): float
    {
        if ($score <= 300) {
            return 200.00;
        }

        if ($score <= 500) {
            return 300.00;
        }

        if ($score <= 700) {
            return 500.00;
        }

        if ($score <= 900) {
            return 700.00;
        }

        return 1000.00;
    }

    /**
     * Gerar número único do contrato
     */
    public function gerarNumeroContrato(): string
    {
        do {
            $numero = 'CT' . date('Y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Contrato::where('numero_contrato', $numero)->exists());

        return $numero;
    }

    /**
     * Gerar número único do cartão (formato: 4 grupos de 4 dígitos)
     */
    public function gerarNumeroCartao(): string
    {
        do {
            $numero = '';
            for ($i = 0; $i < 4; $i++) {
                $numero .= str_pad(mt_rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            }
        } while (Usuario::where('numero_cartao', $numero)->exists());

        return $numero;
    }

    /**
     * Upload do documento de identidade
     */
    public function uploadDocumentoIdentidade(UploadedFile $arquivo, Usuario $usuario): string
    {
        $nomeArquivo = 'documento_' . $usuario->id . '_' . time() . '.' . $arquivo->getClientOriginalExtension();

        $path = $arquivo->storeAs('contratos/documentos', $nomeArquivo, 'public');

        return $path;
    }

    /**
     * Definir limite manual para um usuário
     */
    public function definirLimiteManual(Usuario $usuario, float $limite, string $motivo = null, int $adminId = null): Usuario
    {
        $limiteSugerido = $usuario->limite_credito_sugerido ?? 0;

        $usuario->update([
            'limite_credito_manual' => $limite,
            'motivo_limite_manual' => $limite != $limiteSugerido ? $motivo : null,
            'limite_aprovado_por' => $adminId,
            'data_aprovacao_limite' => now(),
        ]);

        return $usuario->fresh();
    }

    /**
     * Atualizar score de um usuário
     */
    public function atualizarScore(Usuario $usuario, int $novoScore): Usuario
    {
        $limiteSugerido = $this->calcularLimitePorScore($novoScore);

        $usuario->update([
            'score_atual' => $novoScore,
            'limite_credito_sugerido' => $limiteSugerido,
            'data_ultima_consulta_score' => now(),
        ]);

        // Se o usuário tem contrato, atualizar a data de próxima revisão
        if ($usuario->contrato) {
            $usuario->contrato->update([
                'data_proxima_revisao_score' => Carbon::now()->addDays(Configuracao::prazoRevisaoScoreDias())
            ]);
        }

        return $usuario->fresh();
    }

    /**
     * Cancelar contrato
     */
    public function cancelarContrato(Contrato $contrato, string $protocoloCancelamento = null): Contrato
    {
        if (!$contrato->podeSerCancelado()) {
            throw new \Exception('Este contrato não pode ser cancelado.');
        }

        $contrato->update([
            'status' => Contrato::STATUS_CANCELADO,
            'protocolo_cancelamento' => $protocoloCancelamento,
        ]);

        return $contrato->fresh();
    }

    /**
     * Ativar contrato (após confirmação CPFL)
     */
    public function ativarContrato(Contrato $contrato, string $protocoloCpfl = null): Contrato
    {
        $contrato->update([
            'status' => Contrato::STATUS_ATIVO,
            'protocolo_cpfl' => $protocoloCpfl,
            'enviado_cpfl_em' => now(),
        ]);

        return $contrato->fresh();
    }

    /**
     * Obter usuários que precisam de revisão de score
     */
    public function usuariosParaRevisaoScore()
    {
        return Usuario::precisaRevisaoScore()
            ->comContratoAtivo()
            ->with(['contrato', 'adminLimiteAprovadoPor'])
            ->get();
    }

    /**
     * Obter tabela de referência de scores e limites
     */
    public function tabelaReferenciaScores(): array
    {
        return [
            ['score_min' => 0, 'score_max' => 300, 'limite' => 200.00],
            ['score_min' => 301, 'score_max' => 500, 'limite' => 300.00],
            ['score_min' => 501, 'score_max' => 700, 'limite' => 500.00],
            ['score_min' => 701, 'score_max' => 900, 'limite' => 700.00],
            ['score_min' => 901, 'score_max' => 1000, 'limite' => 1000.00],
        ];
    }
}
