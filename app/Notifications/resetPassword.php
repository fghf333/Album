<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class resetPassword
 * @package App\Notifications
 */
class resetPassword extends Notification
{

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email = (new MailMessage)
            ->from('support@happy-moments.ru', 'Поддержка')
            ->subject('Восстановление пароля')
            ->greeting('Восстановление пароля')
            ->line('Вы получили это письмо, так как мы получили запрос на восстановление пароля для аккаунта зарегистрированного на этот email адресс')
            ->action('Восстановить пароль', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Если это были не вы, можете проигнорировать это письмо')
            ->success();

        return $email;
    }
}
