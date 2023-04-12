<?php

namespace App\Notifications;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Properties\TextProperty;

class GameScheduledNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $event = Event::create()
            ->name(__('Football match! ', [], $notifiable->locale).$this->invitation->date->toFormattedDateString())
            ->description(__('Football match! ', [], $notifiable->locale).$this->invitation->date->toFormattedDateString().__(' at ', [], $notifiable->locale).$this->invitation->stadium->formattedAddress())
            ->uniqueIdentifier('KJORA-'.$this->invitation->id)
            ->createdAt($this->invitation->created_at)
            ->startsAt($this->invitation->date)
            ->endsAt($this->invitation->date->addHours(2));

        $calendar = Calendar::create()
            ->productIdentifier('kjora.com')
            ->event(function (Event $event) {
                $event->name('Football match! '.$this->invitation->date->toFormattedDateString())
                    ->attendee($this->invitation->invitingPlayer->email)
                    ->startsAt($this->invitation->date)
                    ->endsAt($this->invitation->date->addHours(2))
                    ->address($this->invitation->date->toFormattedDateString());
            });

        $calendar->appendProperty(TextProperty::create('METHOD', 'REQUEST'));

        return (new MailMessage)
            ->subject(__('Game scheduled', [], $notifiable->locale))
            ->line(__('You have accepted the invitation to the event from ***', [], $notifiable->locale).$this->invitation->invitingPlayer->name.'***.')
            ->attachData($calendar->get(), 'invite.ics', [
                'mime' => 'text/calendar; charset=UTF-8; method=REQUEST',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
