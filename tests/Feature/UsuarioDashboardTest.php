<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Saldo;
use App\Services\SaldoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class UsuarioDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected SaldoService $saldoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->saldoService = app(SaldoService::class);
    }

    /** @test */
    public function usuario_pode_acessar_dashboard_apenas_se_autenticado()
    {
        $response = $this->get('/usuario/dashboard');

        $response->assertRedirect('/usuario/login');
    }

    /** @test */
    public function usuario_ativo_pode_ver_dashboard()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('usuario.dashboard.index');
    }

    /** @test */
    public function dashboard_mostra_saldo_pre_pago_corretamente()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);

        // Adicionar crédito pré-pago
        $this->saldoService->adicionarCreditoPrePago($usuario, 100.00);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Saldo Pré-pago');
        $response->assertSee('R$ 100,00');
    }

    /** @test */
    public function dashboard_mostra_saldo_mensalidade_corretamente()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'meses_gratuitos' => 0,
            'valor_mensalidade' => 50.00
        ]);

        // Processar mensalidade
        $this->saldoService->processarMensalidade($usuario);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Saldo Mensalidade');
        $response->assertSee('R$ 50,00');
    }

    /** @test */
    public function dashboard_mostra_limite_consignado_corretamente()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'limite_disponivel' => 200.00
        ]);

        // Criar saldo limite consignado
        $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Limite Consignado');
        $response->assertSee('R$ 200,00');
    }

    /** @test */
    public function dashboard_mostra_saldo_total_disponivel()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'limite_disponivel' => 200.00,
            'valor_mensalidade' => 50.00
        ]);

        // Adicionar crédito pré-pago
        $this->saldoService->adicionarCreditoPrePago($usuario, 100.00);

        // Processar mensalidade
        $this->saldoService->processarMensalidade($usuario);

        // Criar limite consignado
        $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Saldo Total Disponível');
        $response->assertSee('R$ 350,00'); // 100 + 50 + 200
    }

    /** @test */
    public function dashboard_mostra_status_do_plano_gratuito()
    {
        $dataFim = Carbon::now()->addMonths(3);
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'meses_gratuitos' => 3,
            'data_fim_gratuidade' => $dataFim,
            'valor_mensalidade' => 50.00
        ]);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Mensalidade gratuita até');
        $response->assertSee($dataFim->format('d/m/Y'));
    }

    /** @test */
    public function dashboard_mostra_valor_mensalidade_quando_nao_gratuito()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'meses_gratuitos' => 0,
            'valor_mensalidade' => 75.50
        ]);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Mensalidade: R$ 75,50/mês');
    }

    /** @test */
    public function dashboard_mostra_botao_adicionar_credito()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Adicionar Crédito');
        $response->assertSee(route('usuario.recargas.create'));
    }

    /** @test */
    public function dashboard_mostra_historico_recente()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);

        // Adicionar crédito pré-pago para gerar movimentação
        $this->saldoService->adicionarCreditoPrePago($usuario, 100.00);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Histórico Recente');
        $response->assertSee('Crédito pré-pago adicionado');
    }

    /** @test */
    public function usuario_pendente_nao_pode_acessar_dashboard()
    {
        $usuario = Usuario::factory()->create(['status' => 'pendente']);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertRedirect('/usuario/login');
        $response->assertSessionHas('error', 'Sua conta está pendente');
    }

    /** @test */
    public function usuario_bloqueado_nao_pode_acessar_dashboard()
    {
        $usuario = Usuario::factory()->create(['status' => 'bloqueado']);

        $this->actingAs($usuario, 'usuario');

        $response = $this->get('/usuario/dashboard');

        $response->assertRedirect('/usuario/login');
        $response->assertSessionHas('error', 'Sua conta está bloqueado');
    }
}
