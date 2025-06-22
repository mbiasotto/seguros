<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\SaldoService;
use App\Models\Usuario;
use App\Models\Saldo;
use App\Models\RecargaPrepago;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use App\Models\MovimentacaoSaldo;
use App\Models\Transacao;

class SaldoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected SaldoService $saldoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->saldoService = app(SaldoService::class);
    }

    /** @test */
    public function pode_adicionar_credito_pre_pago()
    {
        $usuario = Usuario::factory()->create();

        $saldo = $this->saldoService->adicionarCreditoPrePago($usuario, 100.00, 'Teste de crédito');

        $this->assertInstanceOf(Saldo::class, $saldo);
        $this->assertEquals(Saldo::TIPO_PRE_PAGO, $saldo->tipo);
        $this->assertEquals(100.00, $saldo->valor_disponivel);
        $this->assertEquals($usuario->id, $saldo->usuario_id);

        // Verificar se movimentação foi criada
        $movimentacao = $saldo->movimentacoes()->first();
        $this->assertNotNull($movimentacao);
        $this->assertEquals(MovimentacaoSaldo::TIPO_CREDITO, $movimentacao->tipo_movimentacao);
        $this->assertEquals(100.00, $movimentacao->valor);
        $this->assertEquals('Teste de crédito', $movimentacao->descricao);
    }

    /** @test */
    public function nao_processa_mensalidade_se_usuario_esta_em_periodo_gratuito()
    {
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 3,
            'data_fim_gratuidade' => now()->addMonths(3),
            'valor_mensalidade' => 50.00,
        ]);

        $saldo = $this->saldoService->processarMensalidade($usuario);

        $this->assertNull($saldo);
    }

    /** @test */
    public function processa_mensalidade_quando_gratuidade_expirou()
    {
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 3,
            'data_fim_gratuidade' => now()->subDay(),
            'valor_mensalidade' => 50.00,
        ]);

        $saldo = $this->saldoService->processarMensalidade($usuario);

        $this->assertInstanceOf(Saldo::class, $saldo);
        $this->assertEquals(Saldo::TIPO_MENSALIDADE, $saldo->tipo);
        $this->assertEquals(50.00, $saldo->valor_disponivel);
    }

    /** @test */
    public function nao_processa_mensalidade_se_valor_mensalidade_eh_zero()
    {
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 0,
            'valor_mensalidade' => 0.00,
        ]);

        $saldo = $this->saldoService->processarMensalidade($usuario);

        $this->assertNull($saldo);
    }

    /** @test */
    public function cria_saldo_limite_consignado_baseado_no_limite_disponivel()
    {
        $usuario = Usuario::factory()->create([
            'limite_disponivel' => 200.00,
        ]);

        $saldo = $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $this->assertInstanceOf(Saldo::class, $saldo);
        $this->assertEquals(Saldo::TIPO_LIMITE_CONSIGNADO, $saldo->tipo);
        $this->assertEquals(200.00, $saldo->valor_disponivel);
        $this->assertNull($saldo->data_expiracao);
    }

    /** @test */
    public function retorna_ordem_correta_de_debito_dos_saldos()
    {
        $usuario = Usuario::factory()->create();

        // Criar saldos em ordem reversa para testar ordenação
        $saldoLimite = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_LIMITE_CONSIGNADO,
            'valor_disponivel' => 100.00,
        ]);

        $saldoMensalidade = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_MENSALIDADE,
            'valor_disponivel' => 50.00,
        ]);

        $saldoPrePago = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_PRE_PAGO,
            'valor_disponivel' => 75.00,
        ]);

        $ordem = $this->saldoService->obterOrdemDebito($usuario);

        $this->assertCount(3, $ordem);
        $this->assertEquals(Saldo::TIPO_PRE_PAGO, $ordem[0]->tipo);
        $this->assertEquals(Saldo::TIPO_MENSALIDADE, $ordem[1]->tipo);
        $this->assertEquals(Saldo::TIPO_LIMITE_CONSIGNADO, $ordem[2]->tipo);
    }

    /** @test */
    public function debita_valor_usando_ordem_de_prioridade()
    {
        $usuario = Usuario::factory()->create();

        // Criar saldos
        $saldoPrePago = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_PRE_PAGO,
            'valor_disponivel' => 30.00,
        ]);

        $saldoMensalidade = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_MENSALIDADE,
            'valor_disponivel' => 50.00,
        ]);

        $saldoLimite = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_LIMITE_CONSIGNADO,
            'valor_disponivel' => 100.00,
        ]);

        // Debitar R$ 60 (deve usar R$ 30 do pré-pago + R$ 30 da mensalidade)
        $movimentacoes = $this->saldoService->debitarValor($usuario, 60.00);

        $this->assertCount(2, $movimentacoes);

        // Verificar se saldos foram atualizados corretamente
        $saldoPrePago->refresh();
        $saldoMensalidade->refresh();
        $saldoLimite->refresh();

        $this->assertEquals(0.00, $saldoPrePago->valor_disponivel);
        $this->assertEquals(20.00, $saldoMensalidade->valor_disponivel);
        $this->assertEquals(100.00, $saldoLimite->valor_disponivel);
    }

    /** @test */
    public function lanca_excecao_quando_saldo_insuficiente()
    {
        $usuario = Usuario::factory()->create();

        Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_PRE_PAGO,
            'valor_disponivel' => 50.00,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Saldo insuficiente para débito');

        $this->saldoService->debitarValor($usuario, 100.00);
    }

    /** @test */
    public function consulta_saldo_detalhado_retorna_estrutura_correta()
    {
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 2,
            'data_fim_gratuidade' => now()->addMonth(),
        ]);

        Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_PRE_PAGO,
            'valor_disponivel' => 100.00,
        ]);

        Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_MENSALIDADE,
            'valor_disponivel' => 50.00,
        ]);

        $detalhes = $this->saldoService->consultarSaldoDetalhado($usuario);

        $this->assertIsArray($detalhes);
        $this->assertArrayHasKey('saldo_total', $detalhes);
        $this->assertArrayHasKey('saldos_detalhados', $detalhes);
        $this->assertArrayHasKey('periodo_gratuito', $detalhes);

        $this->assertEquals(150.00, $detalhes['saldo_total']);
        $this->assertTrue($detalhes['periodo_gratuito']['ativo']);
        $this->assertCount(1, $detalhes['saldos_detalhados']['pre_pago']['saldos']);
        $this->assertCount(1, $detalhes['saldos_detalhados']['mensalidade']['saldos']);
    }

    /** @test */
    public function confirma_recarga_prepago_e_adiciona_credito()
    {
        $usuario = Usuario::factory()->create();
        $recarga = RecargaPrepago::factory()->create([
            'usuario_id' => $usuario->id,
            'valor' => 75.00,
            'status' => RecargaPrepago::STATUS_PENDENTE,
        ]);

        $saldo = $this->saldoService->confirmarRecargaPrepago($recarga, 1);

        $recarga->refresh();

        $this->assertEquals(RecargaPrepago::STATUS_CONFIRMADO, $recarga->status);
        $this->assertNotNull($recarga->data_confirmacao);
        $this->assertEquals(1, $recarga->confirmado_por_admin_id);

        $this->assertEquals(Saldo::TIPO_PRE_PAGO, $saldo->tipo);
        $this->assertEquals(75.00, $saldo->valor_disponivel);
    }

    /** @test */
    public function lanca_excecao_ao_tentar_confirmar_recarga_ja_processada()
    {
        $usuario = Usuario::factory()->create();
        $recarga = RecargaPrepago::factory()->create([
            'usuario_id' => $usuario->id,
            'valor' => 75.00,
            'status' => RecargaPrepago::STATUS_CONFIRMADO,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Recarga não pode ser confirmada');

        $this->saldoService->confirmarRecargaPrepago($recarga, 1);
    }

    /** @test */
    public function expira_saldos_vencidos()
    {
        $usuario = Usuario::factory()->create();

        // Saldo expirado
        $saldoExpirado = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_MENSALIDADE,
            'data_expiracao' => now()->subDay(),
            'status' => Saldo::STATUS_ATIVO,
        ]);

        // Saldo ainda válido
        $saldoValido = Saldo::factory()->create([
            'usuario_id' => $usuario->id,
            'tipo' => Saldo::TIPO_MENSALIDADE,
            'data_expiracao' => now()->addDay(),
            'status' => Saldo::STATUS_ATIVO,
        ]);

        $quantidadeExpirada = $this->saldoService->expirarSaldosVencidos();

        $this->assertEquals(1, $quantidadeExpirada);

        $saldoExpirado->refresh();
        $saldoValido->refresh();

        $this->assertEquals(Saldo::STATUS_EXPIRADO, $saldoExpirado->status);
        $this->assertEquals(Saldo::STATUS_ATIVO, $saldoValido->status);
    }

    /** @test */
    public function debita_valor_com_transacao_na_ordem_correta_multiplos_saldos()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'limite_disponivel' => 200.00,
            'valor_mensalidade' => 50.00
        ]);

        // Criar saldos múltiplos: R$30 pré-pago + R$50 mensalidade + R$200 limite
        $this->saldoService->adicionarCreditoPrePago($usuario, 30.00);
        $this->saldoService->processarMensalidade($usuario);
        $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $transacao = Transacao::factory()->create([
            'usuario_id' => $usuario->id,
            'valor' => 100.00,
        ]);

        // Debitar R$100 com transação
        $breakdown = $this->saldoService->debitarValor($usuario, 100.00, $transacao);

        $this->assertIsArray($breakdown);
        $this->assertCount(3, $breakdown);

        // Verificar breakdown: pré-pago (30) + mensalidade (50) + limite (20)
        $this->assertEquals(30.00, $breakdown[0]['valor_debitado']);
        $this->assertEquals(Saldo::TIPO_PRE_PAGO, $breakdown[0]['tipo']);

        $this->assertEquals(50.00, $breakdown[1]['valor_debitado']);
        $this->assertEquals(Saldo::TIPO_MENSALIDADE, $breakdown[1]['tipo']);

        $this->assertEquals(20.00, $breakdown[2]['valor_debitado']);
        $this->assertEquals(Saldo::TIPO_LIMITE_CONSIGNADO, $breakdown[2]['tipo']);
    }

    /** @test */
    public function cria_movimentacoes_para_cada_debito_com_transacao()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'valor_mensalidade' => 40.00,
            'meses_gratuitos' => 0,
            'data_fim_gratuidade' => now()->subMonth()
        ]);

        // Criar saldos: R$60 pré-pago + R$40 mensalidade
        $this->saldoService->adicionarCreditoPrePago($usuario, 60.00);
        $this->saldoService->processarMensalidade($usuario);

        $transacao = Transacao::factory()->create([
            'usuario_id' => $usuario->id,
            'valor' => 80.00,
        ]);

        $this->saldoService->debitarValor($usuario, 80.00, $transacao);

        // Verificar se movimentações foram criadas para a transação
        $movimentacoes = $transacao->movimentacoes;
        $this->assertCount(2, $movimentacoes);

        // Verificar primeira movimentação (pré-pago - R$60)
        $movPrePago = $movimentacoes->where('saldo.tipo', Saldo::TIPO_PRE_PAGO)->first();
        $this->assertEquals('debito', $movPrePago->tipo_movimentacao);
        $this->assertEquals(60.00, $movPrePago->valor);
        $this->assertEquals($transacao->id, $movPrePago->transacao_id);
        $this->assertStringContainsString('Pagamento', $movPrePago->descricao);

        // Verificar segunda movimentação (mensalidade - R$20)
        $movMensalidade = $movimentacoes->where('saldo.tipo', Saldo::TIPO_MENSALIDADE)->first();
        $this->assertEquals('debito', $movMensalidade->tipo_movimentacao);
        $this->assertEquals(20.00, $movMensalidade->valor);
        $this->assertEquals($transacao->id, $movMensalidade->transacao_id);
        $this->assertStringContainsString('Pagamento', $movMensalidade->descricao);
    }

    /** @test */
    public function debita_valor_sem_transacao_continua_funcionando()
    {
        $usuario = Usuario::factory()->create();

        // Criar saldos
        $this->saldoService->adicionarCreditoPrePago($usuario, 50.00);

        // Debitar sem transação (comportamento antigo)
        $movimentacoes = $this->saldoService->debitarValor($usuario, 30.00);

        $this->assertCount(1, $movimentacoes);
        $this->assertEquals(30.00, $movimentacoes[0]->valor);
        $this->assertNull($movimentacoes[0]->transacao_id);
    }

    /** @test */
    public function calcula_saldo_total_disponivel_corretamente()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'limite_disponivel' => 300.00,
            'valor_mensalidade' => 75.00,
            'meses_gratuitos' => 0,
            'data_fim_gratuidade' => now()->subMonth()
        ]);

        // Criar saldos múltiplos
        $this->saldoService->adicionarCreditoPrePago($usuario, 150.00);
        $this->saldoService->processarMensalidade($usuario);
        $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $saldoTotal = $this->saldoService->calcularSaldoTotalDisponivel($usuario);

        // R$150 pré-pago + R$75 mensalidade + R$300 limite = R$525 total
        $this->assertEquals(525.00, $saldoTotal);
    }

    /** @test */
    public function verifica_se_tem_saldo_suficiente_para_valor()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'limite_disponivel' => 200.00,
            'valor_mensalidade' => 50.00,
            'meses_gratuitos' => 0,
            'data_fim_gratuidade' => now()->subMonth()
        ]);

        // Total: R$250 (R$100 + R$50 + R$200)
        $this->saldoService->adicionarCreditoPrePago($usuario, 100.00);
        $this->saldoService->processarMensalidade($usuario);
        $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $this->assertTrue($this->saldoService->temSaldoSuficiente($usuario, 200.00));
        $this->assertTrue($this->saldoService->temSaldoSuficiente($usuario, 250.00));
        $this->assertFalse($this->saldoService->temSaldoSuficiente($usuario, 400.00)); // Total é R$350, então R$400 deve ser false
    }
}
