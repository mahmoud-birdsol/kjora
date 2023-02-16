<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Conversation;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    /**
     * Store a new conversation message
     *
     * @param \App\Http\Requests\MessageStoreRequest $request
     * @param \App\Models\Conversation $conversation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MessageStoreRequest $request, Conversation $conversation): RedirectResponse
    {
        $conversation->messages()->create([
            'body' => $request->input('body'),
            'sender_id' => auth()->id(),
            'parent_id' => $request->input('parent_id')
        ]);

        $user = $conversation->users()->whereNot('id', $request->user()->id())->first();

        event(new MessageSentEvent($user));

        return redirect()->back();
    }
}
