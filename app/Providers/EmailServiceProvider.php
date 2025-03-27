<?php

namespace App\Providers;

use App\Services\Email\EmailServiceInterface;
use App\Services\Email\PHPMailerService;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EmailServiceInterface::class, function ($app) {
            // Configurações específicas para o PHPMailer
            $config = [
                'host' => 'mbiasotto.com',
                'port' => 587,
                'username' => 'sendrevenda@mbiasotto.com',
                'password' => 'mBsend$20',
                'encryption' => 'tls',
                'from_address' => 'sendrevenda@mbiasotto.com',
                'from_name' => 'SeguraEssa.app'
            ];

            return new PHPMailerService($config);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}