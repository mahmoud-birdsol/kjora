<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\Review;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyPlayerOfReviewNotification extends Notification
{
    use Queueable;

    private User $reviewer;

    private User $player;

    private Review $review;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        User $reviewer,
        User $player,
        Review $review
    ) {
        $this->reviewer = $reviewer;
        $this->player = $player;
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Review Notification')
            ->line('Dear '.$this->reviewer->name)
            ->line('This is to notify you to review player '.$this->player->name)
            ->action('Review Now', url(route('player.review.show', [
                'review' => $this->review,
                'reviewing_user' => $this->reviewer->id,
            ])))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array
    {
        return (new NotificationData(
            displayType: 'simple',
            state: 'success',
            title: 'Review Notification',
            subtitle: 'You now can review Player '.$this->player->name,
            actionData: new RouteActionData(
                route: route('player.review.show', [
                    'review' => $this->review,
                    'reviewing_user' => $this->reviewer->id,
                ]),
                text: 'Review Now',
            ),
        ))->toArray();
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
