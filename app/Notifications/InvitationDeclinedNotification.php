<?php

namespace App\Notifications;

use App\Data\NotificationData;
use App\Data\RouteActionData;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationDeclinedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Invitation $invitation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
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
            ->subject($this->invitation->invitedPlayer->name.__('declined your invitation. ❌', [], $notifiable->locale))
            ->line(__('Your invitation for **', [], $notifiable->locale).$this->invitation->invitedPlayer->name.__('** to play a football match on **', [], $notifiable->locale).$this->invitation->date->toDateTimeString().__('** at **', [], $notifiable->locale).$this->invitation->stadium->name.__('** was declined.', [], $notifiable->locale))
            ->action(__('View Invitation', [], $notifiable->locale), url(route('invitation.index')))
            ->line(__('Thank you for using our application!', [], $notifiable->locale));
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
            state: 'danger',
            title: __('Invitation', [], $notifiable->locale),
            subtitle: __('Your invitation to ', [], $notifiable->locale).$this->invitation->invitedPlayer->name.__(' was declined', [], $notifiable->locale),
            actionData: new RouteActionData(
                route: route('invitation.index'),
                text: __('View Invitation', [], $notifiable->locale),
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
