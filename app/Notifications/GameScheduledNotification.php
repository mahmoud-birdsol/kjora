<?php

namespace App\Notifications;

use App\Models\Invitation;
use Carbon\Carbon;
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
        $invitationDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->invitation->date);
        $invitationDate->setTimezone(str_replace('UTC', '', $notifiable->country->time_zone));

        $event = Event::create()
            ->name(__('Football match! ', [], $notifiable->locale).$invitationDate->toFormattedDateString())
            ->description(__('Football match! ', [], $notifiable->locale).$invitationDate->toFormattedDateString().__(' at ', [], $notifiable->locale).$this->invitation->stadium->formattedAddress())
            ->uniqueIdentifier('KJORA-'.$this->invitation->id)
            ->createdAt($this->invitation->created_at)
            ->startsAt($invitationDate)
            ->endsAt($invitationDate->addHours(2));

        $calendar = Calendar::create()
            ->productIdentifier('kjora.com')
            ->event(function (Event $event) use($invitationDate) {
                $event->name('Football match! '.$invitationDate->toFormattedDateString())
                    ->attendee($this->invitation->invitingPlayer->email)
                    ->startsAt($invitationDate)
                    ->endsAt($invitationDate->addHours(2))
                    ->address($invitationDate->toFormattedDateString());
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
