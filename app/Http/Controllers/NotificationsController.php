<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationsController extends Controller
{
    /**
     * Display the notifications list page.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Notifications/Index', [
            'notifications' => $request->user()->notifications()->paginate(),
        ]);
    }

    /**
     * Delete the specified notification.
     */
    public function destroy(Request $request, string $notificationId): RedirectResponse
    {
        $request->user()->notifications()->where('id', $notificationId)->first()->delete();

        return redirect()->back();
    }
}
