<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuarioAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_pode_acessar_formulario_de_login()
    {
        $response = $this->get('/usuario/login');

        $response->assertStatus(200);
        $response->assertViewIs('usuario.auth.login');
        $response->assertSee('CPF');
        $response->assertSee('Senha');
    }

    /** @test */
    public function usuario_pode_fazer_login_com_cpf_e_senha()
    {
        $usuario = Usuario::factory()->create([
            'cpf' => '12345678901',
            'password' => Hash::make('password123'),
            'status' => 'ativo'
        ]);

        $response = $this->post('/usuario/login', [
            'cpf' => '12345678901',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/usuario/dashboard');
        $this->assertAuthenticatedAs($usuario, 'usuario');
    }

    /** @test */
    public function usuario_pode_fazer_login_com_cpf_formatado()
    {
        $usuario = Usuario::factory()->create([
            'cpf' => '12345678901',
            'password' => Hash::make('password123'),
            'status' => 'ativo'
        ]);

        $response = $this->post('/usuario/login', [
            'cpf' => '123.456.789-01', // CPF com formatação
            'password' => 'password123'
        ]);

        $response->assertRedirect('/usuario/dashboard');
        $this->assertAuthenticatedAs($usuario, 'usuario');
    }

    /** @test */
    public function apenas_usuarios_ativos_podem_fazer_login()
    {
        $usuario = Usuario::factory()->create([
            'cpf' => '12345678901',
            'password' => Hash::make('password123'),
            'status' => 'pendente'
        ]);

        $response = $this->post('/usuario/login', [
            'cpf' => '12345678901',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/usuario/login');
        $response->assertSessionHas('error', 'Sua conta está pendente');
        $this->assertGuest('usuario');
    }

    /** @test */
    public function usuario_bloqueado_nao_pode_fazer_login()
    {
        $usuario = Usuario::factory()->create([
            'cpf' => '12345678901',
            'password' => Hash::make('password123'),
            'status' => 'bloqueado'
        ]);

        $response = $this->post('/usuario/login', [
            'cpf' => '12345678901',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/usuario/login');
        $response->assertSessionHas('error', 'Sua conta está bloqueado');
        $this->assertGuest('usuario');
    }

    /** @test */
    public function login_com_credenciais_invalidas_falha()
    {
        $usuario = Usuario::factory()->create([
            'cpf' => '12345678901',
            'password' => Hash::make('password123'),
            'status' => 'ativo'
        ]);

        $response = $this->post('/usuario/login', [
            'cpf' => '12345678901',
            'password' => 'senhaerrada'
        ]);

        $response->assertRedirect('/usuario/login');
        $response->assertSessionHasErrors(['cpf']);
        $this->assertGuest('usuario');
    }

    /** @test */
    public function usuario_pode_fazer_logout()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);

        $this->actingAs($usuario, 'usuario');

        $response = $this->post('/usuario/logout');

        $response->assertRedirect('/usuario/login');
        $this->assertGuest('usuario');
    }

    /** @test */
    public function usuario_autenticado_nao_pode_acessar_login()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/login');

        $response->assertRedirect('/usuario/dashboard');
    }

    /** @test */
    public function sessoes_de_usuario_e_estabelecimento_sao_independentes()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);
        $estabelecimento = \App\Models\Estabelecimento::factory()->create(['status' => 'ativo']);

        // Login como usuário
        $this->actingAs($usuario, 'usuario');
        $this->assertAuthenticatedAs($usuario, 'usuario');
        $this->assertGuest('estabelecimento');

        // Fazer logout do usuário
        $this->post('/usuario/logout');
        $this->assertGuest('usuario');

        // Login como estabelecimento
        $this->actingAs($estabelecimento, 'estabelecimento');
        $this->assertAuthenticatedAs($estabelecimento, 'estabelecimento');
        $this->assertGuest('usuario');
    }

    /** @test */
    public function login_com_rate_limiting()
    {
        $usuario = Usuario::factory()->create([
            'cpf' => '12345678901',
            'password' => Hash::make('password123'),
            'status' => 'ativo'
        ]);

        // Fazer 5 tentativas com senha errada
        for ($i = 0; $i < 5; $i++) {
            $this->post('/usuario/login', [
                'cpf' => '12345678901',
                'password' => 'senhaerrada'
            ]);
        }

        // A 6ª tentativa deve ser bloqueada
        $response = $this->post('/usuario/login', [
            'cpf' => '12345678901',
            'password' => 'password123' // senha correta
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    /** @test */
    public function validacao_de_campos_obrigatorios()
    {
        $response = $this->post('/usuario/login', []);

        $response->assertSessionHasErrors(['cpf', 'password']);
    }
}
