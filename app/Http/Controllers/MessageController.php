<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use App\Models\Conversation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        return redirect()->back();
    }
}
