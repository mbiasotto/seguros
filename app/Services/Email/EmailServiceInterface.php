<?php

namespace App\Services\Email;

interface EmailServiceInterface
{
    /**
     * Envia um e-mail
     *
     * @param string $to Endereço de e-mail do destinatário
     * @param string $toName Nome do destinatário
     * @param string $subject Assunto do e-mail
     * @param string $body Corpo do e-mail (HTML)
     * @param array $attachments Anexos do e-mail (opcional)
     * @return bool
     * @throws \Exception
     */
    public function send(string $to, string $toName, string $subject, string $body, array $attachments = []): bool;

    /**
     * Envia um e-mail usando um template Blade
     *
     * @param string $to Endereço de e-mail do destinatário
     * @param string $toName Nome do destinatário
     * @param string $subject Assunto do e-mail
     * @param string $template Nome do template Blade
     * @param array $data Dados para o template
     * @param array $attachments Anexos do e-mail (opcional)
     * @return bool
     * @throws \Exception
     */
    public function sendTemplate(string $to, string $toName, string $subject, string $template, array $data = [], array $attachments = []): bool;
}