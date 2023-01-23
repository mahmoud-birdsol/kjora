<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Fetch the user notifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications;

        $request->whenFilled('read', function () use (&$notifications) {
            $notifications = $notifications->user()->unreadNotifications;
        });

        return $notifications;
    }
}
