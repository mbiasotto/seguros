<?php

namespace App\Notifications;

use App\Mail\VendorResetPassword;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class VendorResetPasswordNotification extends ResetPassword
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array|false
     */
    public function via($notifiable)
    {
        // Enviar e-mail usando nossa classe de e-mail personalizada
        $url = url(route('vendor.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        Mail::to($notifiable->getEmailForPasswordReset())
            ->send(new VendorResetPassword($url));

        // Retornar false para indicar que o sistema de notificações não deve
        // enviar nada para nenhum canal
        return false;
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Este método não será chamado porque via() retorna false
        return (new MailMessage)
            ->subject('Redefinição de Senha - Área do Vendedor SeguraEssa.app');
    }
}
