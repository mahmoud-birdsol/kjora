<?php

namespace App\Actions;

use App\Models\Conversation;
use App\Models\Message;

class MarkMessagesAsReadAction
{
    /**
     * Mark Messages as read when page is visited action
     */
    public function __invoke(Conversation $conversation): void
    {
        $conversation->messages()
            ->whereNot('sender_id', request()->user()->id)
            ->whereNull('read_at')
            ->get()->each(function (Message $message) {
                $message->update([
                    'read_at' => now(),
                ]);
            });
    }
}
