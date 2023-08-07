<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JoinPlatformNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
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
            ->subject(__('Join ', [], $notifiable->locale).config('app.name'))
            ->line(__('Welcome to ', [], $notifiable->locale).config('app.name').__(' you have been invited to join the platform.', [], $notifiable->locale))
            ->line(__('please-click-on-the-button-below-to-be-redirected-to-safe-page-to-update-your-password-and-join-the-platform', [], $notifiable->locale))
            ->action(__('Notification Action', [], $notifiable->locale), url(route('join-platform.create', $this->token)))
            ->line(__('Thank you for using our application!', [], $notifiable->locale));
    }
}
