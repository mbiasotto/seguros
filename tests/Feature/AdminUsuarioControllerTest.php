<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUsuarioControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com'
        ]);
    }

    /** @test */
    public function admin_pode_ver_lista_de_usuarios()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.usuarios.index'));

        $response->assertOk();
    }

    /** @test */
    public function admin_pode_ver_formulario_de_criacao_de_usuario()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.usuarios.create'));

        $response->assertOk();
    }

    /** @test */
    public function admin_pode_cadastrar_novo_usuario_com_dados_validos()
    {
        $this->actingAs($this->admin);

        $dadosUsuario = [
            'cpf' => '12345678909', // CPF válido
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'conta_cpfl' => '123456789',
            'limite_total' => 1000.00,
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
        ];

        $response = $this->post(route('admin.usuarios.store'), $dadosUsuario);

        $response->assertRedirect(route('admin.usuarios.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('usuarios', [
            'cpf' => '12345678909',
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'status' => 'pendente',
            'criado_por_admin_id' => $this->admin->id,
        ]);

        $usuario = Usuario::where('cpf', '12345678909')->first();
        $this->assertEquals(1000.00, $usuario->limite_total);
        $this->assertEquals(1000.00, $usuario->limite_disponivel); // Deve ser igual ao total inicialmente
    }

    /** @test */
    public function usuario_criado_deve_ter_status_pendente_por_padrao()
    {
        $this->actingAs($this->admin);

        $dadosUsuario = [
            'cpf' => '12345678909',
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'conta_cpfl' => '123456789',
            'limite_total' => 1000.00,
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
        ];

        $this->post(route('admin.usuarios.store'), $dadosUsuario);

        $this->assertDatabaseHas('usuarios', [
            'cpf' => '12345678909',
            'status' => 'pendente'
        ]);
    }

    /** @test */
    public function cpf_deve_ser_unico_no_sistema()
    {
        $this->actingAs($this->admin);

        // Criar primeiro usuário
        Usuario::create([
            'cpf' => '12345678909',
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'telefone' => '11999999999',
            'password' => bcrypt('password123'),
            'conta_cpfl' => '123456789',
            'limite_total' => 1000.00,
            'limite_disponivel' => 1000.00,
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'criado_por_admin_id' => $this->admin->id,
        ]);

        // Tentar criar usuário com mesmo CPF
        $dadosUsuario = [
            'cpf' => '12345678909', // CPF já existe
            'nome' => 'Maria Silva',
            'email' => 'maria@test.com',
            'telefone' => '11999999998',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'conta_cpfl' => '987654321',
            'limite_total' => 500.00,
            'endereco' => 'Rua das Palmeiras, 456',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234568',
        ];

        $response = $this->post(route('admin.usuarios.store'), $dadosUsuario);

        $response->assertSessionHasErrors(['cpf']);
    }

    /** @test */
    public function email_deve_ser_unico_no_sistema_de_usuarios()
    {
        $this->actingAs($this->admin);

        // Criar primeiro usuário
        Usuario::create([
            'cpf' => '12345678909',
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'telefone' => '11999999999',
            'password' => bcrypt('password123'),
            'conta_cpfl' => '123456789',
            'limite_total' => 1000.00,
            'limite_disponivel' => 1000.00,
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'criado_por_admin_id' => $this->admin->id,
        ]);

        // Tentar criar usuário com mesmo email
        $dadosUsuario = [
            'cpf' => '98765432100',
            'nome' => 'Maria Silva',
            'email' => 'joao@test.com', // Email já existe
            'telefone' => '11999999998',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'conta_cpfl' => '987654321',
            'limite_total' => 500.00,
            'endereco' => 'Rua das Palmeiras, 456',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234568',
        ];

        $response = $this->post(route('admin.usuarios.store'), $dadosUsuario);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function campos_obrigatorios_devem_ser_validados()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.usuarios.store'), []);

        $response->assertSessionHasErrors([
            'cpf', 'nome', 'email', 'telefone', 'password',
            'endereco', 'cidade', 'estado', 'cep'
        ]);
    }

    /** @test */
    public function cpf_deve_ser_valido()
    {
        $this->actingAs($this->admin);

        $dadosUsuario = [
            'cpf' => '12345678901', // CPF inválido
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
        ];

        $response = $this->post(route('admin.usuarios.store'), $dadosUsuario);

        $response->assertSessionHasErrors(['cpf']);
    }

    /** @test */
    public function telefone_deve_ter_formato_correto()
    {
        $this->actingAs($this->admin);

        $dadosUsuario = [
            'cpf' => '12345678909',
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'telefone' => '123', // Telefone inválido
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
        ];

        $response = $this->post(route('admin.usuarios.store'), $dadosUsuario);

        $response->assertSessionHasErrors(['telefone']);
    }

    /** @test */
    public function limite_disponivel_deve_ser_igual_ao_limite_total_na_criacao()
    {
        $this->actingAs($this->admin);

        $dadosUsuario = [
            'cpf' => '12345678909',
            'nome' => 'João Silva',
            'email' => 'joao@test.com',
            'telefone' => '11999999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'conta_cpfl' => '123456789',
            'limite_total' => 1500.00,
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
        ];

        $this->post(route('admin.usuarios.store'), $dadosUsuario);

        $usuario = Usuario::where('cpf', '12345678909')->first();
        $this->assertEquals(1500.00, $usuario->limite_total);
        $this->assertEquals(1500.00, $usuario->limite_disponivel);
    }
}
