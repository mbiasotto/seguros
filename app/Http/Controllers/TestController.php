<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Email\EmailServiceInterface;

class TestController extends Controller
{
    private EmailServiceInterface $emailService;

    /**
     * Construtor
     *
     * @param EmailServiceInterface $emailService
     */
    public function __construct(EmailServiceInterface $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Método temporário para testar o envio de e-mail
     *
     * @return \Illuminate\Http\Response
     */
    public function testEmail()
    {
        try {
            // Endereço de e-mail para teste - usando o mesmo e-mail configurado no sistema
            $to = 'sendrevenda@mbiasotto.com'; // E-mail configurado no sistema
            $toName = 'Usuário de Teste';
            $subject = 'Teste de Envio de E-mail - SeguraEssa.app';

            // Corpo do e-mail simples para teste
            $body = '<h1>Teste de Envio de E-mail</h1>'
                  . '<p>Este é um e-mail de teste enviado pelo sistema SeguraEssa.app.</p>'
                  . '<p>Se você está recebendo este e-mail, significa que a configuração do serviço de e-mail está funcionando corretamente.</p>'
                  . '<p>Data e hora do teste: ' . date('d/m/Y H:i:s') . '</p>';

            // Envia o e-mail
            $result = $this->emailService->send($to, $toName, $subject, $body);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'E-mail enviado com sucesso para ' . $to
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Falha ao enviar e-mail'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar e-mail: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método temporário para testar o envio de e-mail usando template
     *
     * @return \Illuminate\Http\Response
     */
    public function testEmailTemplate()
    {
        try {
            // Endereço de e-mail para teste - usando o mesmo e-mail configurado no sistema
            $to = 'sendrevenda@mbiasotto.com'; // E-mail configurado no sistema
            $toName = 'Usuário de Teste';
            $subject = 'Teste de Template de E-mail - SeguraEssa.app';

            // Dados para o template
            $data = [
                'name' => 'Usuário de Teste',
                'message' => 'Este é um e-mail de teste usando um template Blade.',
                'date' => date('d/m/Y H:i:s')
            ];

            // Envia o e-mail usando o template vendor-welcome existente
            $result = $this->emailService->sendTemplate($to, $toName, $subject, 'emails.vendor-welcome', $data);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'E-mail com template enviado com sucesso para ' . $to
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Falha ao enviar e-mail com template'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar e-mail com template: ' . $e->getMessage()
            ], 500);
        }
    }
}