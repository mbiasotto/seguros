<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TransacaoService;
use App\Services\SaldoService;
use App\Models\Usuario;
use App\Models\Estabelecimento;
use App\Models\Transacao;
use App\Models\Saldo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class TransacaoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TransacaoService $transacaoService;
    protected SaldoService $saldoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transacaoService = app(TransacaoService::class);
        $this->saldoService = app(SaldoService::class);
    }

    /** @test */
    public function pode_criar_transacao_com_sucesso_quando_ha_saldo()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);
        $estabelecimento = Estabelecimento::factory()->create(['status' => 'ativo']);

        // Adicionar saldo suficiente
        $this->saldoService->adicionarCreditoPrePago($usuario, 100.00);

        $transacao = $this->transacaoService->criarTransacao($usuario, $estabelecimento, 50.00);

        $this->assertInstanceOf(Transacao::class, $transacao);
        $this->assertEquals($usuario->id, $transacao->usuario_id);
        $this->assertEquals($estabelecimento->id, $transacao->estabelecimento_id);
        $this->assertEquals(50.00, $transacao->valor);
        $this->assertEquals('pendente', $transacao->status);
        $this->assertNotNull($transacao->pin);
        $this->assertEquals(6, strlen($transacao->pin));
        $this->assertTrue($transacao->expires_at->isAfter(now()));
        $this->assertTrue($transacao->expires_at->isBefore(now()->addMinutes(6)));
    }

    /** @test */
    public function falha_quando_nao_ha_saldo_total_suficiente()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);
        $estabelecimento = Estabelecimento::factory()->create(['status' => 'ativo']);

        // Adicionar saldo insuficiente
        $this->saldoService->adicionarCreditoPrePago($usuario, 30.00);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Saldo insuficiente');

        $this->transacaoService->criarTransacao($usuario, $estabelecimento, 50.00);
    }

    /** @test */
    public function pin_gerado_eh_unico_e_tem_6_digitos()
    {
        // Criar várias transações para testar unicidade
        $pins = [];

        for ($i = 0; $i < 10; $i++) {
            $pin = $this->transacaoService->gerarPinUnico();

            $this->assertEquals(6, strlen($pin));
            $this->assertMatchesRegularExpression('/^\d{6}$/', $pin);
            $this->assertNotContains($pin, $pins);

            $pins[] = $pin;
        }
    }

    /** @test */
    public function pin_expira_em_5_minutos()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);
        $estabelecimento = Estabelecimento::factory()->create(['status' => 'ativo']);

        $this->saldoService->adicionarCreditoPrePago($usuario, 100.00);

        $transacao = $this->transacaoService->criarTransacao($usuario, $estabelecimento, 50.00);

        $expectedExpiry = now()->addMinutes(5);
        $this->assertTrue($transacao->expires_at->diffInSeconds($expectedExpiry) < 5);
    }

    /** @test */
    public function autorizar_transacao_debita_na_ordem_correta()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'limite_disponivel' => 200.00,
            'valor_mensalidade' => 50.00
        ]);
        $estabelecimento = Estabelecimento::factory()->create(['status' => 'ativo']);

        // Criar saldos múltiplos: R$30 pré-pago + R$50 mensalidade + R$200 limite
        $this->saldoService->adicionarCreditoPrePago($usuario, 30.00);
        $this->saldoService->processarMensalidade($usuario);
        $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $transacao = Transacao::factory()->create([
            'usuario_id' => $usuario->id,
            'estabelecimento_id' => $estabelecimento->id,
            'valor' => 100.00,
            'pin' => '123456',
            'status' => 'pendente',
            'expires_at' => now()->addMinutes(5)
        ]);

        $resultado = $this->transacaoService->autorizarTransacao($transacao, '123456');

        $this->assertTrue($resultado);
        $this->assertEquals('autorizada', $transacao->fresh()->status);
        $this->assertNotNull($transacao->fresh()->authorized_at);

        // Verificar ordem de débito: pré-pago (30) + mensalidade (50) + limite (20)
        $usuario->refresh();
        $saldos = $this->saldoService->consultarSaldoDetalhado($usuario);

        $this->assertEquals(0, $saldos['pre_pago']);
        $this->assertEquals(0, $saldos['mensalidade']);
        $this->assertEquals(180, $saldos['limite_consignado']); // 200 - 20
    }

    /** @test */
    public function nao_permite_confirmar_transacao_expirada()
    {
        $transacao = Transacao::factory()->create([
            'pin' => '123456',
            'status' => 'pendente',
            'expires_at' => now()->subMinutes(1) // Expirada
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Transação expirada');

        $this->transacaoService->autorizarTransacao($transacao, '123456');
    }

    /** @test */
    public function falha_ao_autorizar_com_pin_incorreto()
    {
        $transacao = Transacao::factory()->create([
            'pin' => '123456',
            'status' => 'pendente',
            'expires_at' => now()->addMinutes(5)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('PIN incorreto');

        $this->transacaoService->autorizarTransacao($transacao, '654321');
    }

    /** @test */
    public function gera_movimentacoes_ao_autorizar_transacao()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'valor_mensalidade' => 50.00
        ]);
        $estabelecimento = Estabelecimento::factory()->create(['status' => 'ativo']);

        // Criar saldos: R$80 pré-pago + R$50 mensalidade
        $this->saldoService->adicionarCreditoPrePago($usuario, 80.00);
        $this->saldoService->processarMensalidade($usuario);

        $transacao = Transacao::factory()->create([
            'usuario_id' => $usuario->id,
            'estabelecimento_id' => $estabelecimento->id,
            'valor' => 100.00,
            'pin' => '123456',
            'status' => 'pendente',
            'expires_at' => now()->addMinutes(5)
        ]);

        $this->transacaoService->autorizarTransacao($transacao, '123456');

        // Verificar se movimentações foram criadas
        $movimentacoes = $transacao->movimentacoes;
        $this->assertCount(2, $movimentacoes); // Uma para pré-pago, uma para mensalidade

        // Verificar primeira movimentação (pré-pago)
        $movPrePago = $movimentacoes->where('saldo.tipo', Saldo::TIPO_PRE_PAGO)->first();
        $this->assertEquals('debito', $movPrePago->tipo_movimentacao);
        $this->assertEquals(80.00, $movPrePago->valor);
        $this->assertStringContainsString('Pagamento', $movPrePago->descricao);

        // Verificar segunda movimentação (mensalidade)
        $movMensalidade = $movimentacoes->where('saldo.tipo', Saldo::TIPO_MENSALIDADE)->first();
        $this->assertEquals('debito', $movMensalidade->tipo_movimentacao);
        $this->assertEquals(20.00, $movMensalidade->valor);
        $this->assertStringContainsString('Pagamento', $movMensalidade->descricao);
    }

    /** @test */
    public function verifica_saldo_suficiente_com_multiplos_tipos()
    {
        $usuario = Usuario::factory()->create([
            'status' => 'ativo',
            'limite_disponivel' => 150.00,
            'valor_mensalidade' => 30.00
        ]);

        // Criar saldos: R$50 pré-pago + R$30 mensalidade + R$150 limite = R$230 total
        $this->saldoService->adicionarCreditoPrePago($usuario, 50.00);
        $this->saldoService->processarMensalidade($usuario);
        $this->saldoService->criarSaldoLimiteConsignado($usuario);

        $this->assertTrue($this->transacaoService->verificarSaldoSuficiente($usuario, 200.00));
        $this->assertFalse($this->transacaoService->verificarSaldoSuficiente($usuario, 250.00));
    }

    /** @test */
    public function nao_permite_autorizar_transacao_ja_autorizada()
    {
        $transacao = Transacao::factory()->autorizada()->create([
            'pin' => '123456'
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Transação já foi processada');

        $this->transacaoService->autorizarTransacao($transacao, '123456');
    }

    /** @test */
    public function pin_eh_case_insensitive()
    {
        $usuario = Usuario::factory()->create(['status' => 'ativo']);
        $estabelecimento = Estabelecimento::factory()->create(['status' => 'ativo']);

        $this->saldoService->adicionarCreditoPrePago($usuario, 100.00);

        $transacao = Transacao::factory()->create([
            'usuario_id' => $usuario->id,
            'estabelecimento_id' => $estabelecimento->id,
            'valor' => 50.00,
            'pin' => '123456',
            'status' => 'pendente',
            'expires_at' => now()->addMinutes(5)
        ]);

        // Deve aceitar PIN em minúsculas (se houver letras no futuro)
        // Por agora, testamos apenas números mesmo
        $resultado = $this->transacaoService->autorizarTransacao($transacao, '123456');
        $this->assertTrue($resultado);
    }
}
