<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ReinitialisationMotDePasse extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe')
            ->greeting('Bonjour,')
            ->line('Vous recevez ce message car une demande de réinitialisation du mot de passe a été effectuée pour votre compte Concours Masteres.')
            ->action('Réinitialiser mon mot de passe', $url)
            ->line('Ce lien expirera dans '.config('auth.passwords.personnes.expire').' minutes.')
            ->line('Si vous n’êtes pas à l’origine de cette demande, aucune action n’est nécessaire.')
            ->salutation('L’équipe Concours Masteres - INP-HB');
    }
}
