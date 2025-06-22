<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FaturamentoService;
use App\Models\Usuario;
use App\Models\Faturamento;
use Carbon\Carbon;

class TestarFaturamento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:faturamento {acao?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar sistema de faturamento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $acao = $this->argument('acao') ?? 'status';

        switch ($acao) {
            case 'status':
                $this->mostrarStatus();
                break;
            case 'processar':
                $this->processarMensalidades();
                break;
            default:
                $this->error("Ação inválida. Use: status, processar");
        }
    }

    private function mostrarStatus()
    {
        $this->info('=== STATUS DO SISTEMA ===');

        $usuarios = Usuario::all();
        $this->info("\n👥 USUÁRIOS:");
        foreach ($usuarios as $usuario) {
            $gratuito = $usuario->meses_gratuitos > 0 ? "✅ Gratuito" : "❌ Paga";
            $this->info("  {$usuario->nome} - {$gratuito}");
        }

        $faturamentos = Faturamento::doMes(now()->format('Y-m'))->get();
        $this->info("\n💰 FATURAMENTOS JUNHO:");
        if ($faturamentos->isEmpty()) {
            $this->warn("  Nenhum faturamento");
        } else {
            foreach ($faturamentos as $fat) {
                $this->info("  {$fat->usuario->nome} - R$ {$fat->valor_total}");
            }
        }
    }

    private function processarMensalidades()
    {
        $this->info('🔄 Processando mensalidades...');

        $service = app(FaturamentoService::class);
        $resultado = $service->processarTodasMensalidades();

        $this->info("✅ Processados: {$resultado['usuarios_processados']}");
        $this->info("✅ Geradas: {$resultado['mensalidades_geradas']}");
        $this->info("✅ Total: R$ {$resultado['valor_total_gerado']}");
    }
}
