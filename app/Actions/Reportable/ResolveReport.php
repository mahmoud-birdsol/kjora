<?php

namespace App\Actions\Reportable;

use App\Models\Report;
use App\Notifications\ReportResolvedNotification;
use Carbon\Carbon;

class ResolveReport
{
    /**
     * Resolve the report incident.
     */
    public function __invoke(Report $report, string $message = null, ?Carbon $dateTime = null): void
    {
        $report->markAsResolved($dateTime);

        if (is_null($message)) {
            return;
        }

        $report->user?->notify(new ReportResolvedNotification($report, $message));
    }
}
