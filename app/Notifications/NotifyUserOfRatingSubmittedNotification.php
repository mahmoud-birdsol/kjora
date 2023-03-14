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

class NotifyUserOfRatingSubmittedNotification extends Notification
{
    use Queueable;

    private User $reviewer;

    private User $player;

    private Review $review;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $reviewer, User $player, Review $review)
    {
        $this->reviewer = $reviewer;
        $this->player = $player;
        $this->review = $review;
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
            ->subject(__('New Chat Message Notification', [] , $notifiable->locale))
            ->line(__('Dear ', [] , $notifiable->locale) . $this->player->name)
            ->line(__('Player ') . $this->reviewer->name . __(' has submitted a review for you', [] , $notifiable->locale))
            ->action(__('Click here to review ', [] , $notifiable->locale), url(route('player.review.show', [
                'review' => Review::where('reviewer_id', $this->player->id)->where('player_id', $this->reviewer->id)->first(),
                'reviewing_player' => $this->player->id,
            ])))
            ->line(__('Thank you for using our application!', [] , $notifiable->locale));
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
            title: __('Review Notification', [] , $notifiable->locale),
            subtitle: __('Player ', [] , $notifiable->locale) . $this->reviewer->name . __(' has submitted a review for you', [] , $notifiable->locale),
            actionData: new RouteActionData(
                route: route('player.review.show', [
                    'review' => Review::where('reviewer_id', $this->player->id)->where('player_id', $this->reviewer->id)->first(),
                    'reviewing_player' => $this->player->id,
                ]),
                text: __('Review Now', [] , $notifiable->locale),
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
