<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Estabelecimento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estabelecimento>
 */
class EstabelecimentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estabelecimento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $taxaMultiplic = $this->faker->randomFloat(2, 1, 5);
        $taxaEstabelecimento = 100 - $taxaMultiplic;

        return [
            'cnpj' => $this->gerarCnpjValido(),
            'razao_social' => $this->faker->company() . ' LTDA',
            'nome_fantasia' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'telefone' => $this->faker->numerify('11#########'),
            'password' => Hash::make('password123'),
            'endereco' => $this->faker->streetAddress(),
            'numero' => $this->faker->buildingNumber(),
            'bairro' => $this->faker->secondaryAddress(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
            'cep' => $this->faker->numerify('########'),
            'categoria_id' => \App\Models\Categoria::inRandomOrder()->first()->id ?? \App\Models\Categoria::factory(),
            'taxa_multiplic' => $taxaMultiplic,
            'taxa_estabelecimento' => $taxaEstabelecimento,
            'status' => $this->faker->randomElement(['pendente', 'ativo', 'bloqueado']),
            'criado_por_admin_id' => User::factory(),
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
     * Com categoria específica
     */
    public function comCategoria($categoriaId): static
    {
        return $this->state(fn (array $attributes) => [
            'categoria_id' => $categoriaId,
        ]);
    }

    /**
     * Gerar CNPJ válido
     */
    private function gerarCnpjValido(): string
    {
        // Gera os 12 primeiros dígitos
        $cnpj = '';
        for ($i = 0; $i < 12; $i++) {
            $cnpj .= $this->faker->numberBetween(0, 9);
        }

        // Calcula o primeiro dígito verificador
        $soma = 0;
        $pesos = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $pesos[$i];
        }
        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;
        $cnpj .= $digito1;

        // Calcula o segundo dígito verificador
        $soma = 0;
        $pesos = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $pesos[$i];
        }
        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;
        $cnpj .= $digito2;

        return $cnpj;
    }
}
