<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $limiteTotal = $this->faker->randomFloat(2, 100, 5000);

        return [
            'cpf' => $this->gerarCpfValido(),
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->numerify('11#########'),
            'password' => Hash::make('password123'),
            'conta_cpfl' => $this->faker->numerify('#########'),
            'limite_total' => $limiteTotal,
            'limite_disponivel' => $limiteTotal,
            'endereco' => $this->faker->streetAddress(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
            'cep' => $this->faker->numerify('########'),
            'status' => $this->faker->randomElement(['pendente', 'ativo', 'bloqueado']),
            'criado_por_admin_id' => User::factory(),
            'meses_gratuitos' => $this->faker->numberBetween(0, 6),
            'valor_mensalidade' => $this->faker->randomFloat(2, 0, 100),
            'data_fim_gratuidade' => $this->faker->optional(0.5)->dateTimeBetween('now', '+6 months'),
        ];
    }

    /**
     * Estado pendente
     */
    public function pendente(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pendente',
        ]);
    }

    /**
     * Estado ativo
     */
    public function ativo(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ativo',
        ]);
    }

    /**
     * Estado bloqueado
     */
    public function bloqueado(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'bloqueado',
        ]);
    }

    /**
     * Com período de gratuidade ativo
     */
    public function comGratuidadeAtiva(): static
    {
        return $this->state(fn (array $attributes) => [
            'meses_gratuitos' => 3,
            'valor_mensalidade' => 50.00,
            'data_fim_gratuidade' => now()->addMonths(2),
        ]);
    }

    /**
     * Com gratuidade expirada
     */
    public function gratuidadeExpirada(): static
    {
        return $this->state(fn (array $attributes) => [
            'meses_gratuitos' => 3,
            'valor_mensalidade' => 50.00,
            'data_fim_gratuidade' => now()->subDay(),
        ]);
    }

    /**
     * Sem plano de mensalidade
     */
    public function semPlanoMensalidade(): static
    {
        return $this->state(fn (array $attributes) => [
            'meses_gratuitos' => 0,
            'valor_mensalidade' => 0.00,
            'data_fim_gratuidade' => null,
        ]);
    }

    /**
     * Gerar CPF válido
     */
    private function gerarCpfValido(): string
    {
        // Gera os 9 primeiros dígitos
        $cpf = '';
        for ($i = 0; $i < 9; $i++) {
            $cpf .= $this->faker->numberBetween(0, 9);
        }

        // Calcula o primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;
        $cpf .= $digito1;

        // Calcula o segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;
        $cpf .= $digito2;

        return $cpf;
    }
}
