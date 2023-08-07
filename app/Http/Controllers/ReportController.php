<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Jobs\NotifyAdminsOfReportSubmission;
use App\Jobs\NotifyReportedUserOfReportSubmission;
use App\Models\Report;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{
    /**
     * Submit a new report.
     */
    public function store(ReportRequest $request): RedirectResponse
    {
        $report = Report::create($request->validated());

        $report->user()
            ->associate($request->user())
            ->save();

        NotifyAdminsOfReportSubmission::dispatch($report);
        NotifyReportedUserOfReportSubmission::dispatch($report);
        FlashMessage::make()->success(
            message: __('your-report-has-been-submitted-and-will-be-reviewed-by-our-admins-shortly')
        )->closeable()->send();

        return redirect()->back();
    }
}
