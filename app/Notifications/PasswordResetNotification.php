<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Password')
            ->markdown('mail.reset_password');
            $hostname = app(Environment::class)->hostname();
        $url = "http://{$hostname->fqdn}/accounts/reset?token=".$this->token;
        // return (new MailMessage)
        //     ->subject(Lang::get('Reset Password Notification'))
        //     ->greeting("Hello {$notifiable->name},")
        //     ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
        //     ->action(Lang::get('Reset Password'), $url)
        //     ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
        //     ->line(Lang::get('If you did not request a password reset, no further action is required. Token: ===>'.$this->token));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
