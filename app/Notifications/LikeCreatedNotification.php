<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\Comment;
use App\Models\Contracts\Likeable;
use App\Models\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
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
            ->subject($this->like->user->name . __(' liked your ', [] , $notifiable->locale ) . (get_class($this->likeable) == Comment::class ? __('comment!', [] , $notifiable->locale ) : __('post!', [] , $notifiable->locale )))
            ->line($this->like->user->name . __(' liked your ', [] , $notifiable->locale ) . (get_class($this->likeable) == Comment::class ? __('comment!', [] , $notifiable->locale ) : __('post!', [] , $notifiable->locale )))
            ->action(__('View', [] , $notifiable->locale ), $this->likeable->url())
            ->line(__('Thank you for using our application!', [] , $notifiable->locale ));
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
            title: __('Like Notification', [] , $notifiable->locale ),
            subtitle: $this->like->user->name . __(' liked your ', [] , $notifiable->locale ) . (get_class($this->likeable) == Comment::class ? __('comment!', [] , $notifiable->locale ) : __('post!', [] , $notifiable->locale )),
            actionData: new RouteActionData(
                route: $this->likeable->url(),
                text: __('View ', [] , $notifiable->locale ) . (get_class($this->likeable) == Comment::class ? __('comment', [] , $notifiable->locale ) : __('post', [] , $notifiable->locale )),
            ),
            userAvatar: $notifiable->avatar_url,
            userName: $notifiable->name,
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
