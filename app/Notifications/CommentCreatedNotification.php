<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentCreatedNotification extends Notification
{
    use Queueable;

    private User $user;

    private User $notifier;

    private $commentable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, User $notifier, $commentable)
    {
        $this->user = $user;
        $this->notifier = $notifier;
        $this->commentable = $commentable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
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
            ->subject('Comment Notification')
            ->line('Dear '.$this->user->name)
            ->line('This is to notify you that a new comment has been created')
            ->action('Chat Now', url(route('gallery.show', $this->commentable)))
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
        return (new NotificationData(
            displayType: 'user',
            state: 'success',
            title: 'Comment Notification',
            subtitle: 'User '.$this->notifier->name.' commented on your post',
            actionData: new RouteActionData(
                route: route('gallery.show', $this->commentable),
                text: 'Reply',
            ),
            userAvatar: $notifiable->avatar_url,
            userName: $notifiable->name
        ))->toArray();
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
