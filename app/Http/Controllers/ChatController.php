<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Builder;
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

        $query = Conversation::query()->whereHas('users', function ($query) use ($userConversationsIds, $request) {
            $query->whereIn('conversation_user.conversation_id', $userConversationsIds)
                ->whereNot('conversation_user.user_id', $request->user()->id);
        });

        if ($request->has('search')) {
            $query->whereHas('users', function (Builder $query) use ($request) {
                $query->where(function (Builder $query) use ($request) {
                    $query->where('first_name', '%LIKE%', $request->input('search'))
                        ->orWhere('last_name', '%LIKE%', $request->input('search'))
                        ->orWhere('username', '%LIKE%', $request->input('search'));
                });
            });
        }

        return Inertia::render('Chat/Index', [
            'conversations' => $query->with('messages')
                ->with('users', function ($query) use ($request) {
                    $query->whereNot('conversation_user.user_id', $request->user()->id);
                })->get()
        ]);
    }

    /**
     * Display a single conversation with its messages
     *
     * @param \App\Models\Conversation $conversation
     * @return \Inertia\Response
     */
    public function show(Conversation $conversation): Response
    {
        $query = $conversation->messages()->orderBy('created_at', 'DESC');

        if (request()->has('search')) {
            $query->where('body', '%LIKE%', request()->input('search'));
        }

        return Inertia::render('Chat/Show', [
            'messages' => $query->paginate(12),
            'conversation' => $conversation,
            'conversations' => Conversation::query()->whereHas('users', function ($query) use ($conversation) {
                $query->where('conversation_user.conversation_id', $conversation->id)
                    ->whereNot('conversation_user.user_id', request()->user()->id)->with('messages')
                    ->with('users', function ($query) {
                        $query->whereNot('conversation_user.user_id', request()->user()->id);
                    })->get();
            })
        ]);
    }
}
