<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification;

class IdentityVerificationRequest extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', NovaChannel::class];
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
            ->subject($this->user->name.' has uploaded their identification documents.')
            ->line($this->user->name.' has uploaded their identification documents and are waiting for review.')
            ->action('Review', url('/nova/resources/users/'.$this->user->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the nova representation of the notification
     *
     * @return NovaNotification
     */
    public function toNova(): NovaNotification
    {
        return (new NovaNotification)
            ->message($this->user->name.' has uploaded their identification documents.')
            ->action('Review', '/resources/users/'.$this->user->id)
            ->icon('check')
            ->type('success');
    }
}
