<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456'),
            ]
        );

        $this->call([
            EstadoSeeder::class,
            CategorySeeder::class,
            QrCodeSeeder::class,
            EstablishmentSeeder::class,
        ]);

        // Create sample vendors
        $vendors = [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'password' => Hash::make('123456'),
                'telefone' => '(11) 98765-4321',
                'endereco' => 'Rua das Flores, 123',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234-567',
                'observacoes' => 'Vendedor da região sudeste',
                'ativo' => true
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'password' => Hash::make('123456'),
                'telefone' => '(21) 98765-4321',
                'endereco' => 'Av. Atlântica, 456',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'cep' => '20000-001',
                'observacoes' => 'Vendedora da região sul',
                'ativo' => true
            ],
            [
                'nome' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'password' => Hash::make('123456'),
                'telefone' => '(31) 98765-4321',
                'endereco' => 'Rua da Serra, 789',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'cep' => '30000-000',
                'observacoes' => 'Vendedor da região sudeste',
                'ativo' => true
            ]
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}
