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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MessageController extends Controller
{
    /**
     * Return a collection of paginated messages
     */
    public function index(
        Request $request,
        Conversation $conversation
    ): AnonymousResourceCollection {
        $query = $conversation->messages()->orderBy('created_at', 'DESC');

        $request->whenFilled('search', function () use ($query) {
            $query->where('body', 'LIKE', '%'.request()->input('search').'%');
        });

        return MessageResource::collection($query->paginate(12));
    }

    /**
     * Store a new Message
     *
     * @return \App\Http\Resources\MessageResource
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Pusher\ApiErrorException
     * @throws \Pusher\PusherException
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
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
            'parent_id' => $request->input('parent_id'),
        ]);

        if (! is_null($request->attachments)) {
            foreach ($request->attachments as $attachment) {
                $message->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        $user = $conversation->users()->whereNot('conversation_user.user_id', $request->user()->id)->first();

        if ($checkIfUserIsPresentAction($user, $conversation)) {
            event(new MessageSentEvent($user, $message));
        } else {
            $user->notify(new NotifyUserOfChatMessageNotification($user, $request->user(), $conversation));
        }

        return MessageResource::make($message);
    }

    /**
     * Delete the selected Message
     *
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Message $message): JsonResponse
    {
        $message->delete();

        return response()->json([
            'message' => 'Message Deleted Successfully',
        ]);
    }
}
