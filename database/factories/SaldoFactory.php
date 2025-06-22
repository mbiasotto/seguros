<?php

namespace Database\Factories;

use App\Models\Saldo;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Saldo>
 */
class SaldoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $valorOriginal = $this->faker->randomFloat(2, 10, 500);
        $valorDisponivel = $this->faker->randomFloat(2, 0, $valorOriginal);

        return [
            'usuario_id' => Usuario::factory(),
            'tipo' => $this->faker->randomElement([
                Saldo::TIPO_PRE_PAGO,
                Saldo::TIPO_MENSALIDADE,
                Saldo::TIPO_LIMITE_CONSIGNADO
            ]),
            'valor_disponivel' => $valorDisponivel,
            'valor_original' => $valorOriginal,
            'data_credito' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'data_expiracao' => $this->faker->optional(0.3)->dateTimeBetween('now', '+60 days'),
            'status' => Saldo::STATUS_ATIVO,
        ];
    }

    /**
     * Saldo pré-pago
     */
    public function prePago(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => Saldo::TIPO_PRE_PAGO,
            'data_expiracao' => null, // Pré-pago não expira
        ]);
    }

    /**
     * Saldo de mensalidade
     */
    public function mensalidade(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => Saldo::TIPO_MENSALIDADE,
            'data_expiracao' => now()->addMonth(),
        ]);
    }

    /**
     * Saldo de limite consignado
     */
    public function limiteConsignado(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => Saldo::TIPO_LIMITE_CONSIGNADO,
            'data_expiracao' => null, // Limite não expira
        ]);
    }

    /**
     * Saldo expirado
     */
    public function expirado(): static
    {
        return $this->state(fn (array $attributes) => [
            'data_expiracao' => $this->faker->dateTimeBetween('-30 days', '-1 day'),
            'status' => Saldo::STATUS_EXPIRADO,
        ]);
    }

    /**
     * Saldo utilizado (zerado)
     */
    public function utilizado(): static
    {
        return $this->state(fn (array $attributes) => [
            'valor_disponivel' => 0,
            'status' => Saldo::STATUS_UTILIZADO,
        ]);
    }

    /**
     * Com valor específico
     */
    public function comValor(float $valor): static
    {
        return $this->state(fn (array $attributes) => [
            'valor_disponivel' => $valor,
            'valor_original' => $valor,
        ]);
    }
}
