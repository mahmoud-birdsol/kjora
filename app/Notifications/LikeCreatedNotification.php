<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Contracts\Likeable;
use App\Models\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LikeCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Contracts\Likeable
     */
    private Likeable $likeable;

    /**
     * @var \App\Models\Like
     */
    private Like $like;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Likeable $likeable, Like $like)
    {
        $this->likeable = $likeable;
        $this->like = $like;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->like->user->name . ' liked your ' . get_class($this->likeable) == Comment::class ? 'comment!' : 'post!')
            ->line($this->like->user->name . ' liked your ' . get_class($this->likeable) == Comment::class ? 'comment!' : 'post!')
            ->action('View', $this->likeable->url())
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
