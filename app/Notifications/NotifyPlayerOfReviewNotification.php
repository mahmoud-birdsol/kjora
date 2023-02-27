<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyPlayerOfReviewNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    private User $reviewer;

    /**
     * @var \App\Models\User
     */
    private User $player;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $reviewer, User $player)
    {
        $this->reviewer = $reviewer;
        $this->player = $player;
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
            ->subject('Review Notification')
            ->line('Dear ' . $this->reviewer->name)
            ->line('This is to notify you to review player ' . $this->player->name)
            ->action('Review Now', url(route('player.profile', [
                'user' => $this->player,
                'can_review' => true
            ])))
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
            displayType: 'simple',
            state: 'success',
            title: 'Review Notification',
            subtitle: 'You now can review Player ' . $this->player->name,
            actionData: new RouteActionData(
                route: route('player.profile', [
                    'user' => $this->player,
                    'can_review' => true
                ]),
                text: 'Review Now',
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
