<?php

namespace App\Http\Controllers;

use App\Actions\MarkMessagesAsReadAction;
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
            'conversations' => $query->with('users', function ($query) use ($request) {
                $query->whereNot('conversation_user.user_id', $request->user()->id);
            })->get(),
            'last_online_at' => request()->user()->messages()->latest()
        ]);
    }

    /**
     * Display a single conversation with its messages
     *
     * @param \App\Models\Conversation $conversation
     * @param \App\Actions\MarkMessagesAsReadAction $markMessagesAsReadAction
     * @return \Inertia\Response
     */
    public function show(
        Conversation             $conversation,
        MarkMessagesAsReadAction $markMessagesAsReadAction
    ): Response
    {
        $userConversationsIds = request()->user()->conversations->pluck('id');

        $markMessagesAsReadAction($conversation);

        $conversations = Conversation::query()->whereHas('users', function ($query) use ($userConversationsIds) {
            $query->whereIn('conversation_user.conversation_id', $userConversationsIds)
                ->whereNot('conversation_user.user_id', request()->user()->id);
        })
            ->with('users', function ($query) {
                $query->whereNot('conversation_user.user_id', request()->user()->id);
            })->get();

        return Inertia::render('Chat/Show', [
            'conversation' => $conversation,
            'player' => $conversation->users()->whereNot('conversation_user.user_id', request()->user()->id)->first(),
            'conversations' => $conversations,
            'last_online_at' => request()->user()->messages()->latest()
        ]);
    }
}
