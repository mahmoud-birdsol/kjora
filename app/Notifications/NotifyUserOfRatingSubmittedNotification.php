<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\Review;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUserOfRatingSubmittedNotification extends Notification
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
     * @param \App\Models\User $reviewer
     * @param \App\Models\User $player
     * @param \App\Models\Review $review
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
            ->subject('New Chat Message Notification')
            ->line('Dear ' . $this->player->name)
            ->line('Player ' . $this->reviewer->name . ' has submitted a review for you')
            ->action('Click here to review ', url(route('player.review.show', [
                'review' => Review::where('reviewer_id', $this->player->id)->where('player_id', $this->reviewer->id)->first(),
                'reviewing_player' => $this->player->id
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
            subtitle: 'Player ' . $this->reviewer->name . ' has submitted a review for you',
            actionData: new RouteActionData(
                route: route('player.review.show', [
                    'review' => Review::where('reviewer_id', $this->player->id)->where('player_id', $this->reviewer->id)->first(),
                    'reviewing_player' => $this->player->id
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
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
