<?php

namespace App\Services\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\View;

class PHPMailerService implements EmailServiceInterface
{
    /**
     * Configurações do PHPMailer
     */
    private array $config;

    /**
     * Instância do PHPMailer
     */
    private PHPMailer $mailer;

    /**
     * Construtor
     *
     * @param array $config Configurações do serviço de e-mail
     */
    public function __construct(array $config = [])
    {
        // Configurações padrão
        $defaultConfig = [
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'username' => config('mail.mailers.smtp.username'),
            'password' => config('mail.mailers.smtp.password'),
            'encryption' => config('mail.mailers.smtp.encryption', 'tls'),
            'from_address' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'charset' => 'UTF-8'
        ];

        // Mescla as configurações padrão com as configurações fornecidas
        $this->config = array_merge($defaultConfig, $config);

        // Inicializa o PHPMailer
        $this->mailer = new PHPMailer(true);
        $this->setupMailer();
    }

    /**
     * Configura o PHPMailer com as configurações fornecidas
     */
    private function setupMailer(): void
    {
        try {
            // Configurações do servidor SMTP
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->config['host'];
            $this->mailer->Port = $this->config['port'];
            $this->mailer->SMTPSecure = $this->config['encryption'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $this->config['username'];
            $this->mailer->Password = $this->config['password'];
            $this->mailer->CharSet = $this->config['charset'];

            // Configurações do remetente
            $this->mailer->setFrom(
                $this->config['from_address'],
                $this->config['from_name']
            );
        } catch (Exception $e) {
            throw new \Exception('Erro ao configurar o serviço de e-mail: ' . $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send(string $to, string $toName, string $subject, string $body, array $attachments = []): bool
    {
        try {
            // Limpa os destinatários anteriores
            $this->mailer->clearAllRecipients();
            $this->mailer->clearAttachments();

            // Configura o destinatário
            $this->mailer->addAddress($to, $toName);
            $this->mailer->Subject = $subject;

            // Configura o corpo do e-mail
            $this->mailer->isHTML(true);
            $this->mailer->Body = $body;

            // Adiciona anexos, se houver
            foreach ($attachments as $attachment) {
                if (isset($attachment['path'])) {
                    $this->mailer->addAttachment(
                        $attachment['path'],
                        $attachment['name'] ?? '',
                        $attachment['encoding'] ?? 'base64',
                        $attachment['type'] ?? ''
                    );
                }
            }

            // Envia o e-mail
            return $this->mailer->send();
        } catch (Exception $e) {
            throw new \Exception('Erro ao enviar e-mail: ' . $this->mailer->ErrorInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sendTemplate(string $to, string $toName, string $subject, string $template, array $data = [], array $attachments = []): bool
    {
        // Renderiza o template
        $body = View::make($template, $data)->render();

        // Envia o e-mail com o template renderizado
        return $this->send($to, $toName, $subject, $body, $attachments);
    }
}