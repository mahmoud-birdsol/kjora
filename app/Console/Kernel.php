<?php

namespace App\Console;

use App\Jobs\CancelStaleInvitations;
use App\Jobs\CreateReviewForInvitationJob;
use App\Jobs\MarkPendingInvitationsAsCancelledJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Nova\Trix\PruneStaleAttachments;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(new PruneStaleAttachments)->daily();

        $schedule->job(new CreateReviewForInvitationJob())->everyMinute();
//        $schedule->job(new CancelStaleInvitations())->everyMinute();

        $schedule->job(MarkPendingInvitationsAsCancelledJob::dispatch())->everyTenMinutes();
//        $schedule->call(CreateReviewForInvitationJob::dispatch())->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
