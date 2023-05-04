<?php

namespace App\Actions;

use App\Models\Conversation;
use App\Models\Invitation;

class CreateConversationAction
{
    /**
     * Create a new conversation between two users
     */
    public function __invoke(Invitation $invitation): void
    {
        $conversation = Conversation::whereHas('users', function ($query) use ($invitation) {
            $query->where('user_id', $invitation->invitingPlayer->id)->where('is_deleted',false);
        })->whereHas('users', function ($query) use ($invitation) {
            $query->where('user_id', $invitation->invitedPlayer->id)->where('is_deleted',false);
        })->first();

        if (is_null($conversation)) {
            $conversation = Conversation::create();
            $invitation->invitingPlayer->conversations()->attach($conversation->id);
            $invitation->invitedPlayer->conversations()->attach($conversation->id);
        }
    }
}
