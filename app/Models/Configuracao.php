<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracoes';

    protected $fillable = [
        'chave',
        'valor',
        'descricao',
    ];

    /**
     * Buscar configuração por chave
     */
    public static function obter(string $chave, $valorPadrao = null)
    {
        $config = self::where('chave', $chave)->first();
        return $config ? $config->valor : $valorPadrao;
    }

    /**
     * Definir uma configuração
     */
    public static function definir(string $chave, $valor, string $descricao = null): self
    {
        return self::updateOrCreate(
            ['chave' => $chave],
            [
                'valor' => $valor,
                'descricao' => $descricao
            ]
        );
    }

    /**
     * Obter valor da mensalidade CPFL
     */
    public static function valorMensalidadeCpfl(): float
    {
        return (float) self::obter('valor_mensalidade_cpfl', 22.50);
    }

    /**
     * Obter taxa de juros do crédito rotativo
     */
    public static function jurosCreditoRotativo(): float
    {
        return (float) self::obter('juros_credito_rotativo', 15.67);
    }

    /**
     * Obter prazo de revisão de score em dias
     */
    public static function prazoRevisaoScoreDias(): int
    {
        return (int) self::obter('prazo_revisao_score_dias', 180);
    }

    /**
     * Scope por chave
     */
    public function scopeChave($query, string $chave)
    {
        return $query->where('chave', $chave);
    }
}
