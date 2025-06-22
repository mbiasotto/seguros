<?php

namespace Database\Factories;

use App\Models\MovimentacaoSaldo;
use App\Models\Saldo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovimentacaoSaldo>
 */
class MovimentacaoSaldoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $saldoAnterior = $this->faker->randomFloat(2, 0, 1000);
        $valor = $this->faker->randomFloat(2, 1, 100);
        $tipoMovimentacao = $this->faker->randomElement(['credito', 'debito']);

        $saldoPosterior = $tipoMovimentacao === 'credito'
            ? $saldoAnterior + $valor
            : max(0, $saldoAnterior - $valor);

        return [
            'saldo_id' => Saldo::factory(),
            'transacao_id' => null,
            'tipo_movimentacao' => $tipoMovimentacao,
            'valor' => $valor,
            'descricao' => $this->faker->sentence(),
            'saldo_anterior' => $saldoAnterior,
            'saldo_posterior' => $saldoPosterior,
        ];
    }

    /**
     * Movimentação de crédito
     */
    public function credito(): static
    {
        return $this->state(function (array $attributes) {
            $saldoAnterior = $attributes['saldo_anterior'];
            $valor = $attributes['valor'];

            return [
                'tipo_movimentacao' => MovimentacaoSaldo::TIPO_CREDITO,
                'saldo_posterior' => $saldoAnterior + $valor,
                'descricao' => 'Crédito adicionado',
            ];
        });
    }

    /**
     * Movimentação de débito
     */
    public function debito(): static
    {
        return $this->state(function (array $attributes) {
            $saldoAnterior = $attributes['saldo_anterior'];
            $valor = $attributes['valor'];

            return [
                'tipo_movimentacao' => MovimentacaoSaldo::TIPO_DEBITO,
                'saldo_posterior' => max(0, $saldoAnterior - $valor),
                'descricao' => 'Débito realizado',
            ];
        });
    }

    /**
     * Com valor específico
     */
    public function comValor(float $valor): static
    {
        return $this->state(fn (array $attributes) => [
            'valor' => $valor,
        ]);
    }

    /**
     * Com descrição específica
     */
    public function comDescricao(string $descricao): static
    {
        return $this->state(fn (array $attributes) => [
            'descricao' => $descricao,
        ]);
    }
}
