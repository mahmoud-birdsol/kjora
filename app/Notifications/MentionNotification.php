<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\Contracts\HasMentions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MentionNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Contracts\HasMentions
     */
    private HasMentions $hasMentions;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(HasMentions $hasMentions)
    {
        $this->hasMentions = $hasMentions;
    }

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
            ->subject("You were mentioned in text by {$this->hasMentions->user->name}")
            ->line($this->hasMentions->body)
            ->action('View', $this->hasMentions->url($this->hasMentions->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return (new NotificationData(
            displayType: 'user',
            state: 'success',
            title: __('Like Notification', [], $notifiable->locale),
            subtitle: $this->hasMentions->user->username.__(' mentioned you in comment ', [], $notifiable->locale),
            actionData: new RouteActionData(
                route: $this->hasMentions->url($this->hasMentions->id),
                text: __('View ', [], $notifiable->locale),
            ),
            userAvatar: $notifiable->avatar_url,
            userName: $notifiable->name,
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
