<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Восстановление пароля')
            ->greeting('Здравствуйте!')
            ->line('Вы получили это письмо, потому что для вашего аккаунта поступил запрос на сброс пароля.')
            ->action('Сбросить пароль', url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line('Эта ссылка будет действительна в течение 60 минут.')
            ->line('Если вы не запрашивали сброс пароля — просто проигнорируйте это письмо.')
            ->salutation('С уважением, ' . config('app.name'));
    }
}
