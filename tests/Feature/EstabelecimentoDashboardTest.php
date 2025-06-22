<?php

namespace Tests\Feature;

use App\Models\Estabelecimento;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstabelecimentoDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function estabelecimento_pode_acessar_dashboard_apenas_se_autenticado()
    {
        $response = $this->get('/estabelecimento/dashboard');

        $response->assertRedirect('/estabelecimento/login');
    }

    /** @test */
    public function estabelecimento_ativo_pode_ver_dashboard()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('estabelecimento.dashboard.index');
    }

    /** @test */
    public function dashboard_mostra_nome_e_status_do_estabelecimento()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'nome_fantasia' => 'Loja Teste',
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Loja Teste');
        $response->assertSee('ativo');
    }

    /** @test */
    public function dashboard_mostra_taxa_multiplic_e_estabelecimento()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'ativo',
            'taxa_multiplic' => 2.5,
            'taxa_estabelecimento' => 97.5,
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Taxa Multiplic: 2,5%');
        $response->assertSee('Taxa Estabelecimento: 97,5%');
    }

    /** @test */
    public function dashboard_mostra_total_vendas_hoje()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Total vendas hoje');
        $response->assertSee('R$ 0,00'); // Inicial sem vendas
    }

    /** @test */
    public function dashboard_mostra_botao_nova_venda()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'ativo',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Nova Venda');
    }

    /** @test */
    public function estabelecimento_pendente_nao_pode_acessar_dashboard()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'pendente',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/dashboard');

        $response->assertRedirect('/estabelecimento/login');
        $response->assertSessionHas('error', 'Sua conta está pendente');
    }

    /** @test */
    public function estabelecimento_bloqueado_nao_pode_acessar_dashboard()
    {
        $categoria = Categoria::factory()->create();
        $estabelecimento = Estabelecimento::factory()->create([
            'status' => 'bloqueado',
            'categoria_id' => $categoria->id
        ]);

        $this->actingAs($estabelecimento, 'estabelecimento');

        $response = $this->get('/estabelecimento/dashboard');

        $response->assertRedirect('/estabelecimento/login');
        $response->assertSessionHas('error', 'Sua conta está bloqueado');
    }
}
