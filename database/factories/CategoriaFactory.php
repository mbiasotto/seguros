<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->company() . ' ' . $this->faker->randomElement(['Store', 'Shop', 'Market', 'Outlet']),
            'descricao' => $this->faker->catchPhrase(),
            'ativo' => $this->faker->boolean(90), // 90% chance de estar ativo
        ];
    }

    /**
     * Estado ativo
     */
    public function ativa()
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => true,
            ];
        });
    }

    /**
     * Estado inativo
     */
    public function inativa()
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => false,
            ];
        });
    }
}
