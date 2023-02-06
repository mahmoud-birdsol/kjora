<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class NotificationsController extends Controller
{
    /**
     * Display the notifications list page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Notifications/Index', [
            'notifications' => $request->user()->notifications()->paginate(),
        ]);
    }

    /**
     * Delete the specified notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $notificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, string $notificationId): RedirectResponse
    {
        $request->user()->notifications()->where('id', $notificationId)->first()->delete();

        return redirect()->back();
    }
}
