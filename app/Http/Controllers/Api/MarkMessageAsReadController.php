<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageReadEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarkMessageAsReadController extends Controller
{
    /**
     * Mark the sent messages as read
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, Message $message): JsonResponse
    {
        $message->forceFill([
            'read_at' => now()
        ]);

        event(new MessageReadEvent($message->refresh()));

        return response()->json([
            'message' => 'The message has been read'
        ]);
    }
}
