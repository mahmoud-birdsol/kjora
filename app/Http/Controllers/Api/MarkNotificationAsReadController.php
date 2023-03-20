<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarkNotificationAsReadController extends Controller
{
    /**
     * Mark the specified notification as read.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $notificationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, string $notificationId): JsonResponse
    {
        $request->user()->notifications()->where('id', $notificationId)->first()->markAsRead();

        return response()->json([
            'message' => 'Message Deleted Successfully',
        ]);
    }
}
