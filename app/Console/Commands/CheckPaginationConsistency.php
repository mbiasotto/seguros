<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckPaginationConsistency extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'check:pagination';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Verifica a consistência da paginação em todas as views';

    /**
     * Executa o comando.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Verificando consistência da paginação...');

        $viewsPath = resource_path('views');
        $files = $this->getAllBladeFiles($viewsPath);

        $paginationPatterns = [
            '->links()' => [],
            '<x-pagination' => [],
        ];

        $nonStandardPattern = '/(?<!{\s)(?<!\$[a-zA-Z0-9_]+)\-\>paginate\s*\(/';
        $nonStandardFiles = [];

        foreach ($files as $file) {
            $content = File::get($file);

            // Verificar uso do método links()
            if (strpos($content, '->links()') !== false) {
                $relativePath = str_replace(resource_path('views') . '/', '', $file);
                $paginationPatterns['->links()'][] = $relativePath;
            }

            // Verificar uso do componente <x-pagination>
            if (strpos($content, '<x-pagination') !== false) {
                $relativePath = str_replace(resource_path('views') . '/', '', $file);
                $paginationPatterns['<x-pagination'][] = $relativePath;
            }

            // Verificar padrões não padronizados (possivelmente)
            if (preg_match($nonStandardPattern, $content)) {
                $relativePath = str_replace(resource_path('views') . '/', '', $file);
                $nonStandardFiles[] = $relativePath;
            }
        }

        // Exibir resultados
        $this->info('Arquivos que usam o método links(): ' . count($paginationPatterns['->links()']));
        foreach ($paginationPatterns['->links()'] as $file) {
            $this->line('- ' . $file);
        }

        $this->info('Arquivos que usam o componente <x-pagination>: ' . count($paginationPatterns['<x-pagination']));
        foreach ($paginationPatterns['<x-pagination'] as $file) {
            $this->line('- ' . $file);
        }

        if (count($nonStandardFiles) > 0) {
            $this->warn('Possíveis implementações não padronizadas:');
            foreach ($nonStandardFiles as $file) {
                $this->line('- ' . $file);
            }
        } else {
            $this->info('Nenhuma implementação não padronizada encontrada.');
        }

        $this->info('Verificação concluída!');

        return Command::SUCCESS;
    }

    /**
     * Obtém todos os arquivos .blade.php de um diretório, recursivamente.
     *
     * @param string $directory
     * @return array
     */
    private function getAllBladeFiles($directory)
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}
