<?php

namespace App\Actions;

use App\Models\Conversation;
use App\Models\User;
use Pusher\Pusher;

class CheckIfUserIsPresentAction
{

    /**
     * Check if user is present or not
     *
     * @param \App\Models\User $user
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Pusher\ApiErrorException
     * @throws \Pusher\PusherException
     */
    public function __invoke(User $user, Conversation $conversation): bool
    {
        $connection = config('broadcasting.connections.pusher');
        $pusher = new Pusher(
            $connection['key'],
            $connection['secret'],
            $connection['app_id'],
            $connection['options'] ?? []
        );

        $channel = $pusher->getChannelInfo('private-users.chat.' . $conversation->id);


        return (bool)$channel->occupied;
    }
}
