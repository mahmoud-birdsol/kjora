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
        $conversation = Conversation::create();
        $invitation->invitingPlayer->conversations()->attach($conversation->id);
        $invitation->invitedPlayer->conversations()->attach($conversation->id);
    }
}
