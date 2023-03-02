<?php

namespace App\Actions;

use App\Models\Conversation;
use App\Models\Invitation;

class CreateConversationAction
{
    /**
     * Create a new conversation between two users
     *
     * @param \App\Models\Invitation $invitation
     * @return void
     */
    public function __invoke(Invitation $invitation): void
    {
        $conversation = Conversation::whereHas('users', function ($query) use ($invitation) {
            $query->whereIn('user_id', [
                $invitation->invitingPlayer->id,
                $invitation->invitedPlayer->id
            ]);
        })->first();

//        if (is_null($conversation)) {
            $conversation = Conversation::create();
            $invitation->invitingPlayer->conversations()->attach($conversation->id);
            $invitation->invitedPlayer->conversations()->attach($conversation->id);
//        }
    }
}
