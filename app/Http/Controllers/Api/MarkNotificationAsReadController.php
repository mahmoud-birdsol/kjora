<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkNotificationAsReadController extends Controller
{
    /**
     * Mark the specified notification as read.
     */
    public function __invoke(Request $request, string $notificationId): JsonResponse
    {
        if (Auth::check()) {
            Auth::user()->notifications()->where('id', $notificationId)->first()->markAsRead();
        }

        return response()->json([
            'message' => 'Message Deleted Successfully',
        ]);
    }
}
