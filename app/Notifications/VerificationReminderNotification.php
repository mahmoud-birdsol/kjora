<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationReminderNotification extends Notification
{
    use Queueable;

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
        return (new MailMessage)
            ->subject(__('Verification Reminder', [], $notifiable->locale))
            ->line(__('This is a reminder that you haven\'t uploaded your verification documents to ', [], $notifiable->locale).config('app.name'))
            ->action(__('Verify Account'), url(route('profile.show')))
            ->line(__('Thank you for using our application!'));
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
            'type' => 'warning',
            'title' => __('Identity verification.', [], $notifiable->locale),
            'subtitle' => __('please-upload-your-identity-verification-documents-for-review', [], $notifiable->locale),
            'action' => route('profile.show'),
        ];
    }
}
