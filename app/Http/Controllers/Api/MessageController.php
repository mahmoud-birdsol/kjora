<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckIfUserIsPresentAction;
use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\NotifyUserOfChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessageController extends Controller
{
    /**
     * Return a collection of paginated messages
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Conversation $conversation
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(
        Request $request,
        Conversation $conversation
    ): AnonymousResourceCollection {
        $query = $conversation->messages()->orderBy('created_at', 'DESC');

        $request->whenFilled('search', function () use ($request, $query) {
            $query->where('body', 'LIKE', '%' . request()->input('search') . '%');
        });

        return MessageResource::collection($query->paginate(12));
    }

    /**
     * Store a new Message
     *
     * @param \App\Http\Requests\MessageStoreRequest $request
     * @param \App\Models\Conversation $conversation
     * @param \App\Actions\CheckIfUserIsPresentAction $checkIfUserIsPresentAction
     * @return \App\Http\Resources\MessageResource
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Pusher\ApiErrorException
     * @throws \Pusher\PusherException
     */
    public function store(
        MessageStoreRequest $request,
        Conversation $conversation,
        CheckIfUserIsPresentAction $checkIfUserIsPresentAction
    ) {
        /** @var Message $message */
        $message = $conversation->messages()->create([
            'body' => $request->input('body'),
            'sender_id' => $request->user()->id,
            'parent_id' => $request->input('parent_id')
        ]);

        $request->whenFilled('attachments', function () use ($request, $message) {
            foreach ($request->input('attachments') as $attachment) {
                $message->addMedia($attachment)->toMediaCollection('attachments');
            }
        });

        $user = $conversation->users()->whereNot('conversation_user.user_id', $request->user()->id)->first();

        if ($checkIfUserIsPresentAction($user, $conversation)) {
            event(new MessageSentEvent($user, $message));
        } else {
            $user->notify(new NotifyUserOfChatMessageNotification($user, $request->user(), $conversation));
        }

        return MessageResource::make($message);
    }
}
