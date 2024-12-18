<?php

namespace App\Http\Controllers;

use App\Actions\CreateConversationAction;
use App\Models\Conversation;
use App\Models\Invitation;
use App\Models\User;
use App\Services\FlashMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    /**
     * Display all the users conversations
     */
    public function index(Request $request): Response
    {
        $userConversationsIds = $request->user()->conversations->pluck('id');

        $query = Conversation::query()->whereHas('users', function (Builder $query) use ($userConversationsIds, $request) {
            $query->whereIn('conversation_user.conversation_id', $userConversationsIds)
                ->whereNot('conversation_user.user_id', $request->user()->id)
                ->where('conversation_user.is_deleted', '!=', true);
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
            'last_online_at' => request()->user()->last_seen_at,
        ]);
    }

    /**
     * Display a single conversation with its messages
     */
    public function show(Conversation $conversation): Response
    {
        $userConversationsIds = request()->user()->conversations->pluck('id');

        $conversations = Conversation::query()->whereHas('users', function (Builder $query) use ($userConversationsIds) {
            $query->whereIn('conversation_user.conversation_id', $userConversationsIds)
                ->whereNot('conversation_user.user_id', request()->user()->id)
                ->where('conversation_user.is_deleted', '!=', true);
        })
            ->with('users', function ($query) {
                $query->whereNot('conversation_user.user_id', request()->user()->id);
            })->get();

        return Inertia::render('Chat/Show', [
            'conversation' => $conversation->load('users'),
            'player' => $conversation->users()->whereNot('conversation_user.user_id', request()->user()->id)->first(),
            'conversations' => $conversations,
            'last_online_at' => request()->user()->messages()?->orderBy('created_at', 'DESC')?->first()?->created_at,
        ]);
    }

    /**
     * Delete the conversation for me
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Conversation $conversation)
    {
        $user = $conversation->users()->where('conversation_user.user_id', '!=', request()->user()->id)->first();
        $conversation->users()
            ->updateExistingPivot($user->id, [
                'is_deleted' => true,
            ]);

        FlashMessage::make()->success(
            message: __('Conversation Deleted Successfully')
        )->closeable()->send();

        return redirect()->route('chats.index');
    }

    public function showByUserID(Request $request , User $user , Invitation $invitation , CreateConversationAction $createConversationAction)
    {
        $conversations = Conversation::query()->whereHas('users', function (Builder $query) use($request)  {
            $query->where('conversation_user.user_id', $request->user()->id);
        })->whereHas('users', function (Builder $query) use($user)  {
            $query->where('conversation_user.user_id', $user->id)
                ->where('conversation_user.is_deleted', '!=', true);
        })->first();
        if (!$conversations){
            $createConversationAction($invitation);
            $conversations = Conversation::query()->whereHas('users', function (Builder $query) use($request)  {
                $query->where('conversation_user.user_id', $request->user()->id);
            })->whereHas('users', function (Builder $query) use($user)  {
                $query->where('conversation_user.user_id', $user->id)
                    ->where('conversation_user.is_deleted', '!=', true);
            })->first();
        }
        return redirect()->route('chats.show',$conversations->id);
    }
}
