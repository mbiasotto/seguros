<?php

namespace Database\Factories;

use App\Models\Faturamento;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faturamento>
 */
class FaturamentoFactory extends Factory
{
    protected $model = Faturamento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(),
            'mes_referencia' => $this->faker->date('Y-m'),
            'valor_transacoes' => $this->faker->randomFloat(2, 0, 500),
            'valor_mensalidade' => 29.90,
            'valor_total' => function (array $attributes) {
                return $attributes['valor_transacoes'] + $attributes['valor_mensalidade'];
            },
            'conta_cpfl' => $this->faker->numerify('######'),
            'status' => 'aberto',
            'arquivo_cpfl_gerado_em' => null,
            'enviado_em' => null,
            'pago_em' => null,
        ];
    }

    /**
     * Indicate that the faturamento is fechado.
     */
    public function fechado(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'fechado',
        ]);
    }

    /**
     * Indicate that the faturamento is enviado.
     */
    public function enviado(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'enviado',
            'enviado_em' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'arquivo_cpfl_gerado_em' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the faturamento is pago.
     */
    public function pago(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pago',
            'enviado_em' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'pago_em' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'arquivo_cpfl_gerado_em' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Set specific month reference.
     */
    public function mesReferencia(string $mes): static
    {
        return $this->state(fn (array $attributes) => [
            'mes_referencia' => $mes,
        ]);
    }

    /**
     * Set specific values.
     */
    public function comValores(float $valorTransacoes, float $valorMensalidade = 29.90): static
    {
        return $this->state(fn (array $attributes) => [
            'valor_transacoes' => $valorTransacoes,
            'valor_mensalidade' => $valorMensalidade,
            'valor_total' => $valorTransacoes + $valorMensalidade,
        ]);
    }
}
