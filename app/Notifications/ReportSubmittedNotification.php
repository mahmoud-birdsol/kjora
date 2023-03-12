<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification;

class ReportSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\Report
     */
    private Report $report;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', NovaChannel::class];
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
            ->subject(__('New report submitted ⚠️' , [] , $notifiable->locale))
            ->line($this->report->user->name . __(' has submitted a report.', [] , $notifiable->locale))
            ->action(__('Review', [] , $notifiable->locale), '/resources/reports/' . $this->report->id)
            ->line(__('Thank you for using our application!', [] , $notifiable->locale));
    }

    /**
     * Get the nova representation of the notification
     *
     * @return NovaNotification
     */
    public function toNova(): NovaNotification
    {
        return (new NovaNotification)
            ->message($this->report->user->name . __(' has submitted a report.'))
            ->action(__('Review'), '/resources/reports/' . $this->report->id)
            ->icon('check')
            ->type(__('success'));
    }
}
