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

    /**
     * @var \App\Models\Invitation
     */
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
            ->subject($this->invitation->invitedPlayer->name . ' declined your invitation. ❌')
            ->line('Your invitation for **'.$this->invitation->invitedPlayer->name.'** to play a football match on **'.$this->invitation->date->toDateTimeString().'** at **'.$this->invitation->stadium->name.'** was declined.')
            ->action('View Invitation', url(route('invitation.index')))
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
            state: 'danger',
            title: 'Invitation',
            subtitle: 'Your invitation to ' . $this->invitation->invitedPlayer->name . ' was declined',
            actionData: new RouteActionData(
                route: route('invitation.index'),
                text: 'View Invitation',
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
