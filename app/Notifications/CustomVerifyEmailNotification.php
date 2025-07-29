<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('Verifikasi Alamat Email Anda'))
            ->greeting('Halo, ' . $notifiable->username . '!')
            ->line(Lang::get('Terima kasih telah mendaftar di Platform Satgas PPKPT Kampus Surabaya. Mohon klik tombol di bawah ini untuk memverifikasi alamat email Anda.'))
            ->action(Lang::get('Verifikasi Email'), $verificationUrl)
            ->line(Lang::get('Jika Anda tidak merasa mendaftar, Anda bisa mengabaikan email ini.'))
            ->salutation('Hormat kami, Tim Satgas PPKPT Kampus Surabaya');
    }
}
