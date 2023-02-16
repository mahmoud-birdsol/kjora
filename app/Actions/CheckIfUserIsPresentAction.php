<?php

namespace App\Actions;

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
    public function __invoke(User $user): bool
    {
        $connection = config('broadcasting.connections.pusher');
        $pusher = new Pusher(
            $connection['key'],
            $connection['secret'],
            $connection['app_id'],
            $connection['options'] ?? []
        );

        $channel = $pusher->getChannelInfo('private-users.chat.' . $user->id);


        return (bool)$channel->occupied;
    }
}
