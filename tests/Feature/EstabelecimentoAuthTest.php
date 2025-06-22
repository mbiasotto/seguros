<?php

namespace Tests\Feature;

use App\Models\Estabelecimento;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EstabelecimentoAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function estabelecimento_pode_acessar_formulario_de_login()
    {
        $response = $this->get('/estabelecimento/login');

        $response->assertStatus(200);
        $response->assertViewIs('estabelecimento.auth.login');
        $response->assertSee('CNPJ');
        $response->assertSee('Senha');
    }

    /** @test */
    public function estabelecimento_pode_fazer_login_com_cnpj_e_senha()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'cnpj' => '12345678000195',
            'password' => Hash::make('password123'),
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $response = $this->post('/estabelecimento/login', [
            'cnpj' => '12345678000195',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/estabelecimento/dashboard');
        $this->assertAuthenticatedAs($estabelecimento, 'estabelecimento');
    }

    /** @test */
    public function estabelecimento_pode_fazer_login_com_cnpj_formatado()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'cnpj' => '12345678000195',
            'password' => Hash::make('password123'),
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $response = $this->post('/estabelecimento/login', [
            'cnpj' => '12.345.678/0001-95', // CNPJ com formatação
            'password' => 'password123'
        ]);

        $response->assertRedirect('/estabelecimento/dashboard');
        $this->assertAuthenticatedAs($estabelecimento, 'estabelecimento');
    }

    /** @test */
    public function apenas_estabelecimentos_ativos_podem_fazer_login()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'cnpj' => '12345678000195',
            'password' => Hash::make('password123'),
            'status' => 'pendente',
            'categoria_id' => $categoria->id
        ]);

        $response = $this->post('/estabelecimento/login', [
            'cnpj' => '12345678000195',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/estabelecimento/login');
        $response->assertSessionHas('error', 'Sua conta está pendente');
        $this->assertGuest('estabelecimento');
    }

    /** @test */
    public function estabelecimento_bloqueado_nao_pode_fazer_login()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'cnpj' => '12345678000195',
            'password' => Hash::make('password123'),
            'status' => 'bloqueado',
            'categoria_id' => $categoria->id
        ]);

        $response = $this->post('/estabelecimento/login', [
            'cnpj' => '12345678000195',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/estabelecimento/login');
        $response->assertSessionHas('error', 'Sua conta está bloqueado');
        $this->assertGuest('estabelecimento');
    }

    /** @test */
    public function login_com_credenciais_invalidas_falha()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'cnpj' => '12345678000195',
            'password' => Hash::make('password123'),
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $response = $this->post('/estabelecimento/login', [
            'cnpj' => '12345678000195',
            'password' => 'senhaerrada'
        ]);

        $response->assertRedirect('/estabelecimento/login');
        $response->assertSessionHasErrors(['cnpj']);
        $this->assertGuest('estabelecimento');
    }

    /** @test */
    public function estabelecimento_pode_fazer_logout()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->post('/estabelecimento/logout');

        $response->assertRedirect('/estabelecimento/login');
        $this->assertGuest('estabelecimento');
    }

    /** @test */
    public function estabelecimento_autenticado_nao_pode_acessar_login()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/login');

        $response->assertRedirect('/estabelecimento/dashboard');
    }

    /** @test */
    public function validacao_de_campos_obrigatorios()
    {
        $response = $this->post('/estabelecimento/login', []);

        $response->assertSessionHasErrors(['cnpj', 'password']);
    }
}
