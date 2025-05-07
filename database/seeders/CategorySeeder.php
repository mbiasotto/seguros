<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Restaurantes',
            'Lanchonetes',
            'Pizzarias',
            'Bares',
            'Cafeterias',
            'Lojas em Geral',
            'Beleza e Estética',
            'Academias e Estúdios',
            'Clínicas e Consultórios',
            'Farmácias',
            'Oficinas e Serviços Automotivos',
            'Escolas e Cursos',
            'Igrejas e Templos',
            'Associações e ONGs',
            'Clubes e Espaços de Eventos',
            'Mercados e Mercearias',
            'Padarias',
            'Serviços Imobiliários',
            'Concessionárias e Revendas de Veículos',
            'Agências de Turismo',
            'Pet Shops e Clínicas Veterinárias',
            'Casas Lotéricas e Correspondentes Bancários',
            'Lavanderias e Tinturarias',
            'Serviços de Informática e Eletrônicos',
            'Estúdios Criativos (Foto, Vídeo, Design)',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['nome' => $categoryName]);
        }
    }
}
