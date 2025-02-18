<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\Establishment;
use Illuminate\Database\Seeder;

class EstablishmentSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();

        $establishments = [
            [
                'nome' => 'Loja Centro',
                'endereco' => 'Rua Augusta, 1500',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01304-001',
                'telefone' => '(11) 3456-7890',
                'descricao' => 'Loja principal no centro da cidade',
                'ativo' => true
            ],
            [
                'nome' => 'Filial Shopping',
                'endereco' => 'Av. Paulista, 2000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01310-200',
                'telefone' => '(11) 3456-7891',
                'descricao' => 'Filial localizada no shopping',
                'ativo' => true
            ],
            [
                'nome' => 'Loja Zona Sul',
                'endereco' => 'Rua Oscar Freire, 500',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01426-001',
                'telefone' => '(11) 3456-7892',
                'descricao' => 'Loja especializada na zona sul',
                'ativo' => true
            ]
        ];

        foreach ($vendors as $vendor) {
            foreach ($establishments as $establishment) {
                $establishment['vendor_id'] = $vendor->id;
                Establishment::create($establishment);
            }
        }
    }
}
