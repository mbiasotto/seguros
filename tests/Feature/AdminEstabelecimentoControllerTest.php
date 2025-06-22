<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Estabelecimento;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminEstabelecimentoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $categoria;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com'
        ]);

        // Usar firstOrCreate para evitar duplicatas
        $this->categoria = Categoria::firstOrCreate([
            'nome' => 'Loja'
        ], [
            'descricao' => 'Categoria para testes',
            'ativo' => true
        ]);
    }

    /** @test */
    public function admin_pode_ver_lista_de_estabelecimentos()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.estabelecimentos.index'));

        $response->assertOk();
        $response->assertViewIs('admin.estabelecimentos.index');
    }

    /** @test */
    public function admin_pode_ver_formulario_de_criacao_de_estabelecimento()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.estabelecimentos.create'));

        $response->assertOk();
    }

    /** @test */
    public function admin_pode_cadastrar_novo_estabelecimento_com_dados_validos()
    {
        $this->actingAs($this->admin);

        $dadosEstabelecimento = [
            'cnpj' => '11222333000181', // CNPJ válido
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 97.50,
        ];

        $response = $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $response->assertRedirect(route('admin.estabelecimentos.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('estabelecimentos', [
            'cnpj' => '11222333000181',
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'status' => 'pendente',
            'categoria_id' => $this->categoria->id,
            'criado_por_admin_id' => $this->admin->id,
        ]);
    }

    /** @test */
    public function estabelecimento_criado_deve_ter_status_pendente_por_padrao()
    {
        $this->actingAs($this->admin);

        $dadosEstabelecimento = [
            'cnpj' => '11222333000181',
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 97.50,
        ];

        $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $this->assertDatabaseHas('estabelecimentos', [
            'cnpj' => '11222333000181',
            'status' => 'pendente'
        ]);
    }

    /** @test */
    public function cnpj_deve_ser_unico_no_sistema()
    {
        $this->actingAs($this->admin);

        // Criar primeiro estabelecimento
        Estabelecimento::create([
            'cnpj' => '11222333000181',
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '11999999999',
            'password' => bcrypt('password123'),
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 97.50,
            'criado_por_admin_id' => $this->admin->id,
        ]);

        // Tentar criar estabelecimento com mesmo CNPJ
        $dadosEstabelecimento = [
            'cnpj' => '11222333000181', // CNPJ já existe
            'razao_social' => 'Outra Empresa LTDA',
            'nome_fantasia' => 'Loja da Maria',
            'email' => 'maria@loja.com',
            'telefone' => '11999999998',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua das Palmeiras, 456',
            'numero' => '456',
            'bairro' => 'Jardins',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234568',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 3.00,
            'taxa_estabelecimento' => 97.00,
        ];

        $response = $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $response->assertSessionHasErrors(['cnpj']);
    }

    /** @test */
    public function email_deve_ser_unico_no_sistema_de_estabelecimentos()
    {
        $this->actingAs($this->admin);

        // Criar primeiro estabelecimento
        Estabelecimento::create([
            'cnpj' => '11222333000181',
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '11999999999',
            'password' => bcrypt('password123'),
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 97.50,
            'criado_por_admin_id' => $this->admin->id,
        ]);

        // Tentar criar estabelecimento com mesmo email
        $dadosEstabelecimento = [
            'cnpj' => '99888777000199',
            'razao_social' => 'Outra Empresa LTDA',
            'nome_fantasia' => 'Loja da Maria',
            'email' => 'contato@loja.com', // Email já existe
            'telefone' => '11999999998',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua das Palmeiras, 456',
            'numero' => '456',
            'bairro' => 'Jardins',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234568',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 3.00,
            'taxa_estabelecimento' => 97.00,
        ];

        $response = $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function campos_obrigatorios_devem_ser_validados()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.estabelecimentos.store'), []);

        $response->assertSessionHasErrors([
            'cnpj', 'razao_social', 'nome_fantasia', 'email', 'telefone',
            'password', 'endereco', 'numero', 'bairro', 'cidade', 'estado',
            'cep', 'categoria_id', 'taxa_multiplic', 'taxa_estabelecimento'
        ]);
    }

    /** @test */
    public function cnpj_deve_ser_valido()
    {
        $this->actingAs($this->admin);

        $dadosEstabelecimento = [
            'cnpj' => '11222333000100', // CNPJ inválido
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 97.50,
        ];

        $response = $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $response->assertSessionHasErrors(['cnpj']);
    }

    /** @test */
    public function soma_das_taxas_deve_ser_100_porcento()
    {
        $this->actingAs($this->admin);

        $dadosEstabelecimento = [
            'cnpj' => '11222333000181',
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 90.50, // Soma = 93% (erro)
        ];

        $response = $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $response->assertSessionHasErrors(['taxa_estabelecimento']);
    }

    /** @test */
    public function categoria_deve_ser_valida()
    {
        $this->actingAs($this->admin);

        $dadosEstabelecimento = [
            'cnpj' => '11222333000181',
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => 999, // Categoria inexistente
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 97.50,
        ];

        $response = $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $response->assertSessionHasErrors(['categoria_id']);
    }

    /** @test */
    public function telefone_deve_ter_formato_correto()
    {
        $this->actingAs($this->admin);

        $dadosEstabelecimento = [
            'cnpj' => '11222333000181',
            'razao_social' => 'Empresa LTDA',
            'nome_fantasia' => 'Loja do João',
            'email' => 'contato@loja.com',
            'telefone' => '123', // Telefone inválido
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua Comercial, 123',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'categoria_id' => $this->categoria->id,
            'taxa_multiplic' => 2.50,
            'taxa_estabelecimento' => 97.50,
        ];

        $response = $this->post(route('admin.estabelecimentos.store'), $dadosEstabelecimento);

        $response->assertSessionHasErrors(['telefone']);
    }
}
