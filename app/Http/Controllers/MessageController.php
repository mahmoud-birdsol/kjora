<?php

namespace App\Http\Controllers;

use App\Actions\CheckIfUserIsPresentAction;
use App\Events\MessageSentEvent;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Conversation;
use App\Notifications\NotifyUserOfChatMessageNotification;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    /**
     * Store a new conversation message
     *
     * @param \App\Http\Requests\MessageStoreRequest $request
     * @param \App\Models\Conversation $conversation
     * @param \App\Actions\CheckIfUserIsPresentAction $checkIfUserIsPresentAction
     * @return \Illuminate\Http\RedirectResponse
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
    ): RedirectResponse
    {
        /** @var \App\Models\Message $message */
        $message = $conversation->messages()->create([
            'body' => $request->input('body'),
            'sender_id' => auth()->id(),
            'parent_id' => $request->input('parent_id')
        ]);

        if ($request->hasFile('media')) {
            $message->addMedia($request->file('attachments'))->toMediaCollection('attachments');
        }

        $user = $conversation->users()->whereNot('id', $request->user()->id())->first();

        if ($checkIfUserIsPresentAction($user)) {
            event(new MessageSentEvent($user));
        }
        else{
            $user->notify(new NotifyUserOfChatMessageNotification($user, $request->user()));
        }


        return redirect()->back();
    }
}
