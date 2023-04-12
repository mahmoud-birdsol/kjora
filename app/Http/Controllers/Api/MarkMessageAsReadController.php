<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageReadEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarkMessageAsReadController extends Controller
{
    /**
     * Mark the sent messages as read
     */
    public function __invoke(Request $request, Message $message): JsonResponse
    {
        $message->update([
            'read_at' => now(),
        ]);

        event(new MessageReadEvent($message->refresh()));

        return response()->json([
            'message' => 'The message has been read',
        ]);
    }
}
