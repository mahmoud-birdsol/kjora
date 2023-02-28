<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Jobs\NotifyAdminsOfReportSubmission;
use App\Models\Report;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{
    /**
     * Submit a new report.
     *
     * @param \App\Http\Requests\ReportRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReportRequest $request): RedirectResponse
    {
        $report = Report::create($request->validated())
            ->user()
            ->associate($request->user())
            ->save();

        NotifyAdminsOfReportSubmission::dispatch($report);

        FlashMessage::make()->success(
            message: 'Your report has been submitted and will be reviewed by our admins shortly.'
        )->closeable()->send();

        return redirect()->back();
    }
}
