<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUserOfChatMessageNotification extends Notification implements ShouldQueue
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

    /**
     * @var \App\Models\Conversation
     */
    private Conversation $conversation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, User $notifier, Conversation $conversation)
    {
        $this->user = $user;
        $this->notifier = $notifier;
        $this->conversation = $conversation;
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
            ->line('Dear ' . $this->user->name)
            ->line('This is to notify you that a new chat message has been created on your platform.')
            ->action('Chat Now', url(route('chats.show', $this->conversation)))
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
            title: 'Chat Notification',
            subtitle: 'User ' . $this->notifier->name . 'has sent you a message',
            actionData: new RouteActionData(
                route: route('chats.show', $this->conversation),
                text: 'Chat Now',
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
