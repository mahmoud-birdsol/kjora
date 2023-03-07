<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewMessagesController extends Controller
{
    /**
     * Fetch the new messages
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Conversation $conversation
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request, Conversation $conversation): AnonymousResourceCollection
    {
        $messages = Message::whereNot('sender_id', $request->user()->id)
            ->where('conversation_id', $conversation->id)
            ->where('created_at', '>=', now()->addMinute())->get();

        return MessageResource::collection($messages);
    }
}
