<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Report;
use App\Notifications\ReportSubmittedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAdminsOfReportSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Report
     */
    private Report $report;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admins = Admin::all()->filter(function (Admin $admin) {
            return $admin->hasPermissionTo('resolve reports');
        });

        $admins->each->notify(new ReportSubmittedNotification($this->report));
    }
}
