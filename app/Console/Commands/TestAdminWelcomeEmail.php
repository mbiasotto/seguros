<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestAdminWelcomeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-admin-welcome {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um e-mail de teste de boas-vindas para um administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = 'Administrador Teste';
        $password = 'senha123';

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];

        try {
            Mail::send('emails.admin.welcome', $data, function ($message) use ($email, $name) {
                $message->to($email, $name)
                    ->subject('Teste - Bem-vindo ao Painel Administrativo');
            });

            $this->info("E-mail enviado com sucesso para {$email}!");
            $this->info("Verifique os logs em storage/logs/laravel.log");
        } catch (\Exception $e) {
            $this->error("Erro ao enviar e-mail: " . $e->getMessage());
        }
    }
}
