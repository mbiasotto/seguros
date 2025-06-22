<?php

namespace Database\Factories;

use App\Models\RecargaPrepago;
use App\Models\Usuario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecargaPrepago>
 */
class RecargaPrepagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(),
            'valor' => $this->faker->randomFloat(2, 10, 500),
            'forma_pagamento' => $this->faker->randomElement([
                'pix', 'transferencia', 'dinheiro', 'cartao_debito', 'cartao_credito'
            ]),
            'status' => RecargaPrepago::STATUS_PENDENTE,
            'comprovante_url' => $this->faker->optional(0.7)->url(),
            'confirmado_por_admin_id' => null,
            'data_confirmacao' => null,
        ];
    }

    /**
     * Recarga pendente
     */
    public function pendente(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RecargaPrepago::STATUS_PENDENTE,
            'confirmado_por_admin_id' => null,
            'data_confirmacao' => null,
        ]);
    }

    /**
     * Recarga confirmada
     */
    public function confirmada(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RecargaPrepago::STATUS_CONFIRMADO,
            'confirmado_por_admin_id' => User::factory(),
            'data_confirmacao' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Recarga cancelada
     */
    public function cancelada(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RecargaPrepago::STATUS_CANCELADO,
            'confirmado_por_admin_id' => null,
            'data_confirmacao' => null,
        ]);
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
     * Com forma de pagamento específica
     */
    public function comFormaPagamento(string $formaPagamento): static
    {
        return $this->state(fn (array $attributes) => [
            'forma_pagamento' => $formaPagamento,
        ]);
    }

    /**
     * Com comprovante
     */
    public function comComprovante(): static
    {
        return $this->state(fn (array $attributes) => [
            'comprovante_url' => $this->faker->url(),
        ]);
    }

    /**
     * Sem comprovante
     */
    public function semComprovante(): static
    {
        return $this->state(fn (array $attributes) => [
            'comprovante_url' => null,
        ]);
    }
}
