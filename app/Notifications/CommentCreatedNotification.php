<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    private User $user;

    /**
     * @var \App\Models\User
     */
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
            ->subject(__('Comment Notification' , [] , $notifiable->locale ))
            ->line(__('Dear ' , [] , $notifiable->locale ) . $this->user->name)
            ->line(__('This is to notify you that a new comment has been created' , [] , $notifiable->locale ))
            ->action(__('Chat Now' , [] , $notifiable->locale ), url(route('gallery.show', $this->commentable)))
            ->line(__('Thank you for using our application!' , [] , $notifiable->locale ));
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
            title: __('Comment Notification', [] , $notifiable->locale),
            subtitle: __('User ', [] , $notifiable->locale) . $this->notifier->name . __(' commented on your post', [] , $notifiable->locale),
            actionData: new RouteActionData(
                route: route('gallery.show', $this->commentable),
                text: __('View Now', [] , $notifiable->locale),
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
