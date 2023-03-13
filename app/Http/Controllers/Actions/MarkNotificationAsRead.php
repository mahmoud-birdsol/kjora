<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MarkNotificationAsRead extends Controller
{
    /**
     * Mark the specified notification as read.
     */
    public function __invoke(Request $request, string $notificationId): RedirectResponse
    {
        $request->user()->notifications()->where('id', $notificationId)->first()->markAsRead();

        return redirect()->back();
    }
}
