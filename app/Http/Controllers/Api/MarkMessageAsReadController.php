<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MarkMessageAsReadController extends Controller
{
    /**
     * Mark the sent messages as read
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \App\Http\Resources\MessageResource
     */
    public function __invoke(Request $request, Message $message)
    {
        $message->forceFill([
            'read_at' => now()
        ]);

        return MessageResource::make($message->refresh());
    }
}
