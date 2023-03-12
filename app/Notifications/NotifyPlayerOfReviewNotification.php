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

    /**
     * @var \App\Models\User
     */
    private User $reviewer;

    /**
     * @var \App\Models\User
     */
    private User $player;

    /**
     * @var \App\Models\Review
     */
    private Review $review;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        User   $reviewer,
        User   $player,
        Review $review
    )
    {
        $this->reviewer = $reviewer;
        $this->player = $player;
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Review Notification', [] , $notifiable->locale))
            ->line(__('Dear ' , [] , $notifiable->locale) . $this->reviewer->name)
            ->line(__('This is to notify you to review player ',  [] , $notifiable->locale) . $this->player->name)
            ->action(__('Review Now' , [] , $notifiable->locale), url(route('player.review.show', [
                'review' => $this->review,
                'reviewing_user' => $this->reviewer->id
            ])))
            ->line(__('Thank you for using our application!' , [] , $notifiable->locale));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return (new NotificationData(
            displayType: 'simple',
            state: 'success',
            title: __('Review Notification', [] , $notifiable->locale),
            subtitle: __('You now can review Player ', [] , $notifiable->locale) . $this->player->name,
            actionData: new RouteActionData(
                route: route('player.review.show', [
                    'review' => $this->review,
                    'reviewing_user' => $this->reviewer->id
                ]),
                text: __('Review Now', [] , $notifiable->locale),
            ),
        ))->toArray();
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
