<?php

namespace Database\Seeders;

use App\Models\Configuracao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configuracoes = [
            [
                'chave' => 'valor_mensalidade_cpfl',
                'valor' => '22.50',
                'descricao' => 'Valor da mensalidade CPFL em reais'
            ],
            [
                'chave' => 'juros_credito_rotativo',
                'valor' => '15.67',
                'descricao' => 'Taxa de juros do crédito rotativo em percentual ao mês'
            ],
            [
                'chave' => 'prazo_revisao_score_dias',
                'valor' => '180',
                'descricao' => 'Prazo em dias para revisão do score dos usuários'
            ]
        ];

        foreach ($configuracoes as $config) {
            Configuracao::updateOrCreate(
                ['chave' => $config['chave']],
                $config
            );
        }
    }
}
