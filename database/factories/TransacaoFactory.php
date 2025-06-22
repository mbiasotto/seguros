<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Estabelecimento;
use App\Models\Transacao;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transacao>
 */
class TransacaoFactory extends Factory
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
            'estabelecimento_id' => Estabelecimento::factory(),
            'valor' => $this->faker->randomFloat(2, 10, 500),
            'pin' => $this->faker->unique()->numerify('######'),
            'status' => 'pendente',
            'expires_at' => now()->addMinutes(5),
            'authorized_at' => null,
        ];
    }

    /**
     * Estado para transação autorizada
     */
    public function autorizada(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'autorizada',
            'authorized_at' => now(),
        ]);
    }

    /**
     * Estado para transação expirada
     */
    public function expirada(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'expirada',
            'expires_at' => now()->subMinutes(10),
        ]);
    }

    /**
     * Estado para transação cancelada
     */
    public function cancelada(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelada',
        ]);
    }

    /**
     * Estado para transação pendente que expira em breve
     */
    public function expiraEmBreve(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => now()->addSeconds(30),
        ]);
    }

    /**
     * Estado com valor específico
     */
    public function comValor(float $valor): static
    {
        return $this->state(fn (array $attributes) => [
            'valor' => $valor,
        ]);
    }

    /**
     * Estado com PIN específico
     */
    public function comPin(string $pin): static
    {
        return $this->state(fn (array $attributes) => [
            'pin' => $pin,
        ]);
    }
}
