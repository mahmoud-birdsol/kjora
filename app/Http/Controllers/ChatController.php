<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    /**
     * Display all the users conversations
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        $userConversationsIds = $request->user()->conversations->pluck('id');

        $conversations = Conversation::whereHas('users', function ($query) use ($userConversationsIds, $request) {
            $query->whereIn('conversation_user.conversation_id', $userConversationsIds)
                ->whereNot('conversation_user.user_id', $request->user()->id);
        })->with('messages')->get();

        return Inertia::render('Chat/Index', [
            'conversations' => $conversations
        ]);
    }
}
