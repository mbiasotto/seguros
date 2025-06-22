<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Usuario;
use App\Models\Estabelecimento;
use App\Models\Categoria;
use App\Services\SaldoService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        echo "🌱 Criando dados básicos de teste...\n";

        // 1. Admin já existe via AdminSeeder
        $admin = User::where('email', 'admin@admin.com')->first();

        // 2. Usar categorias existentes
        $categoria = Categoria::first();

        // 3. Criar estabelecimento básico
        echo "🏪 Criando estabelecimento...\n";
        $estabelecimento = Estabelecimento::updateOrCreate(['email' => 'teste@teste.com'], [
            'categoria_id' => $categoria->id,
            'razao_social' => 'Empresa Teste LTDA',
            'nome_fantasia' => 'Loja Teste',
            'cnpj' => '12345678000100',
            'email' => 'teste@teste.com',
            'telefone' => '11999888777',
            'password' => Hash::make('123456'),
            'endereco' => 'Rua Teste, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'taxa_multiplic' => 2.5,
            'taxa_estabelecimento' => 1.0,
            'status' => 'ativo',
            'criado_por_admin_id' => $admin->id,
        ]);

        // 4. Criar usuários de teste
        echo "👥 Criando usuários...\n";

        // Usuário 1: Ativo com período gratuito
        $usuario1 = Usuario::updateOrCreate(['email' => 'joao@teste.com'], [
            'cpf' => '12345678901',
            'nome' => 'João Silva',
            'email' => 'joao@teste.com',
            'telefone' => '11987654321',
            'password' => Hash::make('123456'),
            'conta_cpfl' => '123456789',
            'limite_total' => 1000.00,
            'limite_disponivel' => 1000.00,
            'endereco' => 'Rua A, 100',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'status' => 'ativo',
            'criado_por_admin_id' => $admin->id,
            'meses_gratuitos' => 3,
            'valor_mensalidade' => 29.90,
            'data_fim_gratuidade' => now()->addMonths(2),
        ]);

        // Usuário 2: Ativo sem período gratuito
        $usuario2 = Usuario::updateOrCreate(['email' => 'maria@teste.com'], [
            'cpf' => '98765432100',
            'nome' => 'Maria Santos',
            'email' => 'maria@teste.com',
            'telefone' => '11876543210',
            'password' => Hash::make('123456'),
            'conta_cpfl' => '987654321',
            'limite_total' => 500.00,
            'limite_disponivel' => 500.00,
            'endereco' => 'Rua B, 200',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'status' => 'ativo',
            'criado_por_admin_id' => $admin->id,
            'meses_gratuitos' => 3,
            'valor_mensalidade' => 39.90,
            'data_fim_gratuidade' => now()->subMonth(),
        ]);

        // 5. Criar saldos para os usuários
        echo "💰 Criando saldos...\n";
        $saldoService = app(SaldoService::class);

        // Saldos para usuário 1
        $saldoService->adicionarCreditoPrePago($usuario1, 150.00, 'Recarga inicial de teste');

        // Saldos para usuário 2
        $saldoService->adicionarCreditoPrePago($usuario2, 80.00, 'Recarga inicial de teste');

        echo "✅ Dados básicos criados com sucesso!\n\n";

        echo "🎯 CREDENCIAIS DE ACESSO:\n";
        echo "═══════════════════════════════════════\n";
        echo "🔐 ADMIN:\n";
        echo "   URL: http://localhost:8000/admin\n";
        echo "   Email: admin@admin.com\n";
        echo "   Senha: 1234\n\n";

        echo "👥 USUÁRIOS:\n";
        echo "   URL: http://localhost:8000/usuario/login\n";
        echo "   1. João Silva: joao@teste.com / 123456\n";
        echo "   2. Maria Santos: maria@teste.com / 123456\n\n";

        echo "🏪 ESTABELECIMENTO:\n";
        echo "   URL: http://localhost:8000/estabelecimento/login\n";
        echo "   Loja Teste: teste@teste.com / 123456\n\n";
    }
}
