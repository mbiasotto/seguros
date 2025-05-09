<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Establishment;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class EstablishmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create vendors first
        $vendors = [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@example.com',
                'password' => bcrypt('password'),
                'telefone' => '(11) 98765-4321',
                'ativo' => true
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria.santos@example.com',
                'password' => bcrypt('password'),
                'telefone' => '(11) 98765-4322',
                'ativo' => true
            ],
            [
                'nome' => 'Carlos Oliveira',
                'email' => 'carlos.oliveira@example.com',
                'password' => bcrypt('password'),
                'telefone' => '(11) 98765-4323',
                'ativo' => true
            ]
        ];

        foreach ($vendors as $vendorData) {
            Vendor::firstOrCreate(
                ['email' => $vendorData['email']],
                $vendorData
            );
        }

        // Create establishments and associate with vendors
        $establishments = [
            [
                'nome' => 'Restaurante Sabor Brasileiro',
                'endereco' => 'Rua Augusta, 1500',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01305-100',
                'telefone' => '(11) 3456-7890',
                'email' => 'restaurante@example.com',
                'ativo' => true,
                'vendor_id' => 1,
                'category_id' => 1
            ],
            [
                'nome' => 'Padaria Pão Dourado',
                'endereco' => 'Avenida Paulista, 1000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01310-100',
                'telefone' => '(11) 3456-7891',
                'email' => 'padaria@example.com',
                'ativo' => true,
                'vendor_id' => 1,
                'category_id' => 2
            ],
            [
                'nome' => 'Mercado São José',
                'endereco' => 'Rua dos Pinheiros, 500',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '05422-000',
                'telefone' => '(11) 3456-7892',
                'email' => 'mercado@example.com',
                'ativo' => true,
                'vendor_id' => 2,
                'category_id' => 3
            ],
            [
                'nome' => 'Farmácia Saúde Total',
                'endereco' => 'Avenida Rebouças, 2000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '05402-000',
                'telefone' => '(11) 3456-7893',
                'email' => 'farmacia@example.com',
                'ativo' => true,
                'vendor_id' => 2,
                'category_id' => 4
            ],
            [
                'nome' => 'Lanchonete Sabor & Cia',
                'endereco' => 'Rua Oscar Freire, 1200',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01426-001',
                'telefone' => '(11) 3456-7894',
                'email' => 'lanchonete@example.com',
                'ativo' => true,
                'vendor_id' => 3,
                'category_id' => 5
            ]
        ];

        foreach ($establishments as $establishmentData) {
            Establishment::firstOrCreate(
                ['nome' => $establishmentData['nome'], 'vendor_id' => $establishmentData['vendor_id']],
                $establishmentData
            );
        }
    }
}
