<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IdentityVerifiedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
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
            ->subject(__('Account verified!', [], $notifiable->locale))
            ->line(__('Your account and identity has been verified on ', [], $notifiable->locale).config('app.name').'.')
            ->action('Login', url('/dashboard'))
            ->line(__('Thank you for using our application!', [], $notifiable->locale));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return (new NotificationData(
            displayType: 'simple',
            state: 'success',
            title: __('Identity Verification', [], $notifiable->locale),
            subtitle: __('Your account has been verified', [], $notifiable->locale),
            actionData: new RouteActionData(
                route: route('profile.show'),
                text: __('View Profile', [], $notifiable->locale),
            ),
        ))->toArray();
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
