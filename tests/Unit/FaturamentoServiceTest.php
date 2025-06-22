<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Faturamento;
use App\Models\Transacao;
use App\Models\MovimentacaoSaldo;
use App\Services\FaturamentoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class FaturamentoServiceTest extends TestCase
{
    use RefreshDatabase;

    private FaturamentoService $faturamentoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faturamentoService = app(FaturamentoService::class);
    }

    public function test_usuario_com_3_meses_gratuitos_nao_gera_cobranca_nos_primeiros_meses()
    {
        // Arrange
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 3,
            'data_fim_gratuidade' => now()->addMonths(1)->endOfMonth(),
        ]);

        // Act
        $resultado = $this->faturamentoService->processarMensalidadeUsuario($usuario);

        // Assert
        $this->assertFalse($resultado['deve_cobrar']);
        $this->assertEquals('Usuário ainda está no período gratuito', $resultado['motivo']);
        $this->assertDatabaseMissing('faturamentos', [
            'usuario_id' => $usuario->id,
            'mes_referencia' => now()->format('Y-m'),
        ]);
    }

    public function test_apos_periodo_gratuito_gera_cobranca_correta()
    {
        // Arrange - usuário criado há 4 meses (não no mês atual)
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 3,
            'data_fim_gratuidade' => now()->subMonths(1)->endOfMonth(),
            'valor_mensalidade' => 49.90,
            'conta_cpfl' => '123456',
            'created_at' => now()->subMonths(4)->startOfMonth(),
        ]);

        // Act
        $resultado = $this->faturamentoService->processarMensalidadeUsuario($usuario);

        // Assert
        $this->assertTrue($resultado['deve_cobrar']);
        $this->assertEquals(49.90, $resultado['valor_cobrado']);

        $this->assertDatabaseHas('faturamentos', [
            'usuario_id' => $usuario->id,
            'mes_referencia' => now()->format('Y-m'),
            'valor_mensalidade' => 49.90,
            'conta_cpfl' => '123456',
            'status' => 'aberto',
        ]);

        // Verifica se criou saldo tipo mensalidade
        $this->assertDatabaseHas('saldos', [
            'usuario_id' => $usuario->id,
            'tipo' => 'mensalidade',
            'valor_disponivel' => 49.90,
        ]);

        // Verifica se criou movimentação de crédito
        $saldo = $usuario->saldos()->where('tipo', 'mensalidade')->first();
        $this->assertDatabaseHas('movimentacoes_saldo', [
            'saldo_id' => $saldo->id,
            'tipo_movimentacao' => 'credito',
            'valor' => 49.90,
        ]);
    }

    public function test_nao_permite_processar_mensalidade_duplicada_no_mesmo_mes()
    {
        // Arrange
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 0,
            'valor_mensalidade' => 29.90,
        ]);

        Faturamento::factory()->create([
            'usuario_id' => $usuario->id,
            'mes_referencia' => now()->format('Y-m'),
        ]);

        // Act
        $resultado = $this->faturamentoService->processarMensalidadeUsuario($usuario);

        // Assert
        $this->assertFalse($resultado['deve_cobrar']);
        $this->assertEquals('Mensalidade já processada para este mês', $resultado['motivo']);
    }

    public function test_fechamento_soma_transacoes_e_mensalidades()
    {
        // Arrange
        $mesReferencia = '2024-01';
        $usuario = Usuario::factory()->create();

        // Criar faturamento com mensalidade
        $faturamento = Faturamento::factory()->create([
            'usuario_id' => $usuario->id,
            'mes_referencia' => $mesReferencia,
            'valor_mensalidade' => 29.90,
            'valor_transacoes' => 0,
            'status' => 'aberto',
        ]);

        // Criar transações do mês
        $transacao1 = Transacao::factory()->create([
            'usuario_id' => $usuario->id,
            'valor' => 50.00,
            'status' => 'autorizada',
            'authorized_at' => Carbon::createFromFormat('Y-m-d', '2024-01-15'),
        ]);

        $transacao2 = Transacao::factory()->create([
            'usuario_id' => $usuario->id,
            'valor' => 30.00,
            'status' => 'autorizada',
            'authorized_at' => Carbon::createFromFormat('Y-m-d', '2024-01-20'),
        ]);

        // Act
        $resultado = $this->faturamentoService->fecharMes($mesReferencia);

        // Assert
        $faturamento->refresh();
        $this->assertEquals(80.00, $faturamento->valor_transacoes); // 50 + 30
        $this->assertEquals(29.90, $faturamento->valor_mensalidade);
        $this->assertEquals(109.90, $faturamento->valor_total); // 80 + 29.90
        $this->assertEquals('fechado', $faturamento->status);

        $this->assertArrayHasKey('total_usuarios', $resultado);
        $this->assertArrayHasKey('total_transacoes', $resultado);
        $this->assertArrayHasKey('valor_total_transacoes', $resultado);
    }

    public function test_nao_permite_fechar_mes_duas_vezes()
    {
        // Arrange
        $mesReferencia = '2024-01';

        Faturamento::factory()->fechado()->create([
            'mes_referencia' => $mesReferencia,
        ]);

        // Act & Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Mês já foi fechado');

        $this->faturamentoService->fecharMes($mesReferencia);
    }

    public function test_nao_permite_fechar_mes_atual()
    {
        // Arrange
        $mesAtual = now()->format('Y-m');

        // Act & Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é possível fechar o mês atual');

        $this->faturamentoService->fecharMes($mesAtual);
    }

    public function test_arquivo_cpfl_tem_formato_correto()
    {
        // Arrange
        $mesReferencia = '2024-01';

        $usuario1 = Usuario::factory()->create(['conta_cpfl' => '123456']);
        $usuario2 = Usuario::factory()->create(['conta_cpfl' => '789012']);

        Faturamento::factory()->fechado()->create([
            'usuario_id' => $usuario1->id,
            'mes_referencia' => $mesReferencia,
            'valor_total' => 150.00,
            'conta_cpfl' => '123456',
        ]);

        Faturamento::factory()->fechado()->create([
            'usuario_id' => $usuario2->id,
            'mes_referencia' => $mesReferencia,
            'valor_total' => 89.90,
            'conta_cpfl' => '789012',
        ]);

        // Act
        $resultado = $this->faturamentoService->gerarArquivoCPFL($mesReferencia);

        // Assert
        $this->assertArrayHasKey('caminho_arquivo', $resultado);
        $this->assertArrayHasKey('total_registros', $resultado);
        $this->assertEquals(2, $resultado['total_registros']);

        // Verificar conteúdo do arquivo
        $conteudo = file_get_contents($resultado['caminho_arquivo']);
        $linhas = explode("\n", trim($conteudo));

        $this->assertCount(2, $linhas);

        // Verificar formato: CONTA|VALOR|VENCIMENTO|REFERENCIA
        $linha1 = explode('|', $linhas[0]);
        $this->assertEquals('123456', $linha1[0]); // conta
        $this->assertEquals('150.00', $linha1[1]); // valor
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $linha1[2]); // vencimento
        $this->assertEquals('2024-01', $linha1[3]); // referência

        // Cleanup
        unlink($resultado['caminho_arquivo']);
    }

    public function test_gerar_arquivo_cpfl_apenas_com_faturamentos_fechados()
    {
        // Arrange
        $mesReferencia = '2024-01';

        $usuario = Usuario::factory()->create(['conta_cpfl' => '123456']);

        // Faturamento aberto (não deve incluir)
        Faturamento::factory()->create([
            'usuario_id' => $usuario->id,
            'mes_referencia' => $mesReferencia,
            'status' => 'aberto',
        ]);

        // Act & Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não há faturamentos fechados para o mês');

        $this->faturamentoService->gerarArquivoCPFL($mesReferencia);
    }

    public function test_processar_mensalidade_calcula_valor_proporcional_mes_parcial()
    {
        // Arrange - usuário que começou no meio do mês
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 0,
            'valor_mensalidade' => 30.00,
            'created_at' => Carbon::createFromFormat('Y-m-d', now()->format('Y-m') . '-15'), // dia 15 do mês atual
        ]);

        // Act
        $resultado = $this->faturamentoService->processarMensalidadeUsuario($usuario);

        // Assert
        $diasRestantes = now()->endOfMonth()->day - 14; // Do dia 15 até o final do mês
        $diasTotais = now()->endOfMonth()->day;
        $valorEsperado = round((30.00 * $diasRestantes) / $diasTotais, 2);

        $this->assertTrue($resultado['deve_cobrar']);
        $this->assertEquals($valorEsperado, $resultado['valor_cobrado']);
    }

    public function test_atualizar_conta_cpfl_em_faturamento_existente()
    {
        // Arrange
        $usuario = Usuario::factory()->create([
            'meses_gratuitos' => 0,
            'conta_cpfl' => '123456',
            'valor_mensalidade' => 29.90,
        ]);

        // Faturamento sem conta CPFL
        $faturamento = Faturamento::factory()->create([
            'usuario_id' => $usuario->id,
            'mes_referencia' => now()->format('Y-m'),
            'conta_cpfl' => null,
        ]);

        // Act
        $this->faturamentoService->processarMensalidadeUsuario($usuario);

        // Assert
        $faturamento->refresh();
        $this->assertEquals('123456', $faturamento->conta_cpfl);
    }

    public function test_processar_todas_mensalidades_em_lote()
    {
        // Arrange - criar usuários ativos criados no mês anterior (para evitar cálculo proporcional)
        $usuarioIds = [];
        for ($i = 0; $i < 3; $i++) {
            $usuario = Usuario::factory()->create([
                'meses_gratuitos' => 0,
                'valor_mensalidade' => 29.90,
                'status' => 'ativo',
                'created_at' => now()->subMonth(), // Criado no mês anterior
            ]);
            $usuarioIds[] = $usuario->id;
        }

        // Verificar se foram criados ativos
        $usuariosAtivos = Usuario::where('status', 'ativo')->count();
        $this->assertGreaterThanOrEqual(3, $usuariosAtivos);

        // Act
        $resultado = $this->faturamentoService->processarTodasMensalidades();

        // Assert
        $this->assertEquals(3, $resultado['usuarios_processados']);
        $this->assertEquals(3, $resultado['mensalidades_geradas']);
        $this->assertEqualsWithDelta(89.70, $resultado['valor_total_gerado'], 0.01); // 3 * 29.90 com tolerância

        // Verificar se todos os faturamentos foram criados
        foreach ($usuarioIds as $usuarioId) {
            $this->assertDatabaseHas('faturamentos', [
                'usuario_id' => $usuarioId,
                'mes_referencia' => now()->format('Y-m'),
            ]);
        }
    }
}
